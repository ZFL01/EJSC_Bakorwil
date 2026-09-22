<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

class UserApprovalTest extends TestCase
{
    // Pakai PostgreSQL asli (DB hasil import SQL); perubahan di-rollback otomatis.
    use DatabaseTransactions, UsesPostgresTestDatabase;

    public function test_approve_tetap_sebagai_admin_dan_tetap_di_panel(): void
    {
        $admin = User::create([
            'name' => 'Admin Uji',
            'username' => 'admin'.uniqid(),
            'email' => 'admin'.uniqid().'@bakorwil.go.id',
            'password_hash' => bcrypt('rahasia'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $pending = User::create([
            'name' => 'Pendaftar Baru',
            'username' => 'pendaftar'.uniqid(),
            'email' => 'pendaftar'.uniqid().'@gmail.com',
            'password_hash' => bcrypt('rahasia'),
            'role' => 'talenta',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.approve', $pending));

        // Tetap di panel admin (redirect balik + flash sukses),
        // BUKAN diarahkan ke halaman publik.
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Sesi admin TIDAK digantikan: yang tetap terautentikasi adalah admin,
        // bukan user yang baru disetujui.
        $this->assertAuthenticatedAs($admin);

        $this->assertDatabaseHas('users', [
            'id_user' => $pending->id_user,
            'status' => 'aktif',
        ]);

        // Profil sesuai role tetap dibuat otomatis saat approve.
        $this->assertDatabaseHas('talenta', [
            'id_user' => $pending->id_user,
        ]);
    }
}
