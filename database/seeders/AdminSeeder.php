<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin default bila belum ada (idempoten).
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@bakorwil.go.id')->first();

        if (!$user) {
            $base = 'adminbakorwil';
            $username = $base;
            $i = 1;
            while (User::where('username', $username)->exists()) {
                $username = $base.($i++);
            }

            $user = User::create([
                'name' => 'Administrator',
                'username' => $username,
                'email' => 'admin@bakorwil.go.id',
                'password_hash' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]);

            $this->command->info("Admin dibuat: admin@bakorwil.go.id (id_user: {$user->id_user})");
        } else {
            $user->update([
                'password_hash' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'aktif',
            ]);

            $this->command->info("Admin sudah ada, password di-reset: admin@bakorwil.go.id (id_user: {$user->id_user})");
        }
    }
}
