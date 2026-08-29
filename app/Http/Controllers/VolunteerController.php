<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Http\Requests\UpdateOwnProfileRequest;
use App\Http\Resources\VolunteerResource;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volunteers = Volunteer::with(['user', 'assignments'])->get();
        return VolunteerResource::collection($volunteers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVolunteerRequest $request)
    {
    $volunteer = DB::transaction(function () use ($request) {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
            'role' => 'volunteer',
        ]);

        return Volunteer::create([
            'user_id' => $user->id,
            'phone' => $request->validated('phone'),
        ]);
    });

        $volunteer->load(['user', 'assignments']);

        return new VolunteerResource($volunteer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Volunteer $volunteer)
    {
        $volunteer->load(['user', 'assignments']);

        return new VolunteerResource($volunteer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVolunteerRequest $request, Volunteer $volunteer)
    {
        $this->authorize('update', $volunteer);

        $data = $request->validated();

        DB::transaction(function () use ($data, $volunteer) {

        if (isset($data['name']) || isset($data['email'])) {
            $userData = [];

            if (isset($data['name'])) {
                $userData['name'] = $data['name'];
            }

            if (isset($data['email'])) {
                $userData['email'] = $data['email'];
            }

            $volunteer->user->update($userData);
        }

        if (isset($data['phone'])) {
            $volunteer->update([
                'phone' => $data['phone'],
            ]);
        }
        });

        $volunteer->load(['user', 'assignments']);

        return new VolunteerResource($volunteer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Volunteer $volunteer)
    {
        DB::transaction(function () use ($volunteer) {
        $volunteer->user->delete();
        });

        return response()->json([
            'message' => 'Volunteer deleted successfully',
        ]);
    }

    public function me(Request $request)
    {
        $volunteer = $request->user()->volunteer;

        if (!$volunteer) {
            return response()->json([
              'message' => 'Volunteer profile not found.'
            ], 404);
        }


        $volunteer->load(['user', 'assignments']);

        return new VolunteerResource($volunteer);
    }

    public function updateMe(UpdateOwnProfileRequest $request)
    {
        $volunteer = $request->user()->volunteer;

        if (!$volunteer) {
            return response()->json([
                'message' => 'Volunteer profile not found.'
            ], 404);
        }

        $this->authorize('update', $volunteer);

        $data = $request->validated();

        DB::transaction(function () use ($data, $volunteer) {
         $userData = array_intersect_key($data, array_flip(['name', 'email']));
            if (!empty($userData)) {
                $volunteer->user->update($userData);
            }

            if (isset($data['phone'])) {
                $volunteer->update(['phone' => $data['phone']]);
            }
    });

        $volunteer->load(['user', 'assignments']);

        return new VolunteerResource($volunteer);
    }
}
