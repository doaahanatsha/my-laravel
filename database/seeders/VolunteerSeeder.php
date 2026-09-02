<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'volunteer@gmail.com'],
            [
                'name' => 'Volunteer',
                'password' => Hash::make('12345678'),
                'role' => 'volunteer',
            ]
        );

        if (!$user->volunteer) {
            $user->volunteer()->create([
                'phone' => '0599999999',
            ]);
        }
    }
}