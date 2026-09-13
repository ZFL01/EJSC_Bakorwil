<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserApprovalTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Pakai PostgreSQL asli (DB disetup lewat import SQL).
        // phpunit.xml memaksa DB_DATABASE=:memory:, jadi override di sini.
        config([
            'database.default' => 'pgsql',
            'database.connections.pgsql.database' => 'bakorwil_jember',
        ]);

        DB::purge('pgsql');
    }

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
