<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Bakorwil',
            'email' => 'admin@bakorwil.go.id',
            'password_hash' => Hash::make('Admin123!'),
            'role' => 'admin',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        // Mentor User
        User::create([
            'name' => 'Mentor Example',
            'email' => 'mentor@example.com',
            'password_hash' => Hash::make('Mentor123!'),
            'role' => 'mentor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        // Talent User
        User::create([
            'name' => 'Talent Example',
            'email' => 'talent@example.com',
            'password_hash' => Hash::make('Talent123!'),
            'role' => 'talenta',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        // Client User
        User::create([
            'name' => 'Client Example',
            'email' => 'client@example.com',
            'password_hash' => Hash::make('Client123!'),
            'role' => 'client',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);
    }
}
