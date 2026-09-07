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

    public function test_approve_auto_login_sebagai_user_yang_disetujui(): void
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

        // Diarahkan ke home (bukan halaman admin) karena sekarang
        // yang login adalah user yang baru disetujui.
        $response->assertRedirect(route('public.index'));

        // Auto-login: user yang disetujui kini terautentikasi,
        // bukan lagi admin.
        $this->assertAuthenticatedAs($pending);

        $this->assertDatabaseHas('users', [
            'id_user' => $pending->id_user,
            'status' => 'aktif',
        ]);
    }
}
