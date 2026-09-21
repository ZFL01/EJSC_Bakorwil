<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccountManagementTest extends TestCase
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

    /**
     * Buat satu akun admin untuk kebutuhan test.
     */
    private function makeAdmin(): User
    {
        return User::create([
            'name' => 'Admin Uji',
            'username' => 'admin'.uniqid(),
            'email' => 'admin'.uniqid().'@bakorwil.go.id',
            'password_hash' => Hash::make('rahasia'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);
    }

    public function test_daftar_akun_admin_dapat_dibuka_admin(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get(route('admin.users.admins.index'));

        $response->assertOk();
        $response->assertSee('Kelola Akun Admin');
        $response->assertSee($admin->email);
    }

    public function test_admin_dapat_membuat_akun_admin_baru(): void
    {
        $admin = $this->makeAdmin();
        $email = 'adminbaru'.uniqid().'@bakorwil.go.id';

        $response = $this->actingAs($admin)->post(route('admin.users.admins.store'), [
            'name' => 'Admin Baru',
            'username' => 'adminbaru'.uniqid(),
            'email' => $email,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.users.admins.index'));
        $response->assertSessionHas('success');

        $created = User::where('email', $email)->first();

        $this->assertNotNull($created);
        $this->assertSame('admin', $created->role);
        $this->assertSame('aktif', $created->status);
        $this->assertTrue(Hash::check('rahasia123', $created->password_hash));
    }

    public function test_username_dibuat_otomatis_bila_dikosongkan(): void
    {
        $admin = $this->makeAdmin();
        $email = 'adminotomatis'.uniqid().'@bakorwil.go.id';

        $this->actingAs($admin)->post(route('admin.users.admins.store'), [
            'name' => 'Admin Otomatis',
            'username' => '',
            'email' => $email,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'status' => 'aktif',
        ])->assertSessionHasNoErrors();

        $created = User::where('email', $email)->first();

        $this->assertNotNull($created);
        $this->assertNotEmpty($created->username);
    }

    public function test_admin_dapat_memperbarui_akun_tanpa_mengubah_password(): void
    {
        $admin = $this->makeAdmin();
        $target = $this->makeAdmin();
        $passwordLama = $target->password_hash;

        $response = $this->actingAs($admin)->put(
            route('admin.users.admins.update', $target),
            [
                'name' => 'Nama Diubah',
                'username' => $target->username,
                'email' => $target->email,
                'password' => '',
                'password_confirmation' => '',
                'status' => 'aktif',
            ]
        );

        $response->assertRedirect(route('admin.users.admins.index'));

        $target->refresh();

        $this->assertSame('Nama Diubah', $target->name);
        $this->assertSame($passwordLama, $target->password_hash);
    }

    public function test_admin_tidak_dapat_menghapus_akun_sendiri(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->delete(
            route('admin.users.admins.destroy', $admin)
        );

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id_user' => $admin->id_user]);
    }

    public function test_admin_dapat_menghapus_akun_admin_lain(): void
    {
        $admin = $this->makeAdmin();
        $target = $this->makeAdmin();

        $response = $this->actingAs($admin)->delete(
            route('admin.users.admins.destroy', $target)
        );

        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id_user' => $target->id_user]);
    }

    public function test_user_non_admin_tidak_dapat_mengakses_kelola_admin(): void
    {
        $talenta = User::create([
            'name' => 'Talenta Uji',
            'username' => 'talenta'.uniqid(),
            'email' => 'talenta'.uniqid().'@gmail.com',
            'password_hash' => Hash::make('rahasia'),
            'role' => 'talenta',
            'status' => 'aktif',
        ]);

        $this->actingAs($talenta)
            ->get(route('admin.users.admins.index'))
            ->assertForbidden();
    }

    public function test_form_tambah_dan_edit_akun_admin_dapat_dibuka(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->get(route('admin.users.admins.create'))
            ->assertOk()
            ->assertSee('Tambah Akun Admin');

        $this->actingAs($admin)
            ->get(route('admin.users.admins.edit', $admin))
            ->assertOk()
            ->assertSee('Edit Akun Admin');
    }

    public function test_akun_non_admin_tidak_dapat_diedit_lewat_kelola_admin(): void
    {
        $admin = $this->makeAdmin();

        $mentor = User::create([
            'name' => 'Mentor Uji',
            'username' => 'mentor'.uniqid(),
            'email' => 'mentor'.uniqid().'@gmail.com',
            'password_hash' => Hash::make('rahasia'),
            'role' => 'mentor',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.admins.edit', $mentor))
            ->assertNotFound();

        $this->actingAs($admin)
            ->delete(route('admin.users.admins.destroy', $mentor))
            ->assertNotFound();
    }

    public function test_email_duplikat_ditolak_saat_membuat_admin(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('admin.users.admins.store'), [
            'name' => 'Admin Duplikat',
            'username' => '',
            'email' => $admin->email,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'status' => 'aktif',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
