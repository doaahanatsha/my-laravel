<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) 
{ 
    $request->validate([ 
        'name' => 'required|string|max:255', 
        'email' => 'required|email|unique:users,email', 
        'password' => 'required|min:8', 
        'phone' => 'required|string', 
    ]); 

    $user = DB::transaction(function () use ($request) {
        $user = User::create([ 
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => $request->password, 
            'role' => 'volunteer', 
        ]); 

        Volunteer::create([ 
            'user_id' => $user->id, 
            'phone' => $request->phone, 
        ]); 

        return $user;
    });

    return response()->json([ 
        'message' => 'Volunteer registered successfully', 
        'user' => $user, 
    ], 201); 
}


    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    $user = $request->user();

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}