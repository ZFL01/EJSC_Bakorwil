<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Gunakan koneksi PostgreSQL asli (DB disetup lewat import SQL,
        // bukan migration), sehingga tabel sudah ada.
        // phpunit.xml memaksa DB_DATABASE=:memory:, jadi override di sini.
        config([
            'database.default' => 'pgsql',
            'database.connections.pgsql.database' => 'bakorwil_jember',
        ]);

        DB::purge('pgsql');
    }

    public function test_halaman_registrasi_tampil(): void
    {
        $response = $this->get(route('registrasi'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_halaman_selesai_tampil_setelah_daftar(): void
    {
        session(['register_waiting' => [
            'name'  => 'User Uji',
            'email' => 'useruji@outlook.com',
            'role'  => 'talenta',
        ]]);

        $response = $this->get(route('registrasi.waiting'));

        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Terkirim!');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_registrasi_manual_berhasil_sebagai_pending(): void
    {
        $email = 'uji.'.uniqid().'@outlook.com';

        $response = $this->post('/registrasi', [
            'name' => 'User Uji Coba',
            'email' => $email,
            'role' => 'talenta',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ]);

        $response->assertRedirect(route('registrasi.waiting'));

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'talenta',
            'status' => 'pending',
        ]);

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->username);
    }

    public function test_registrasi_manual_gagal_saat_email_duplikat(): void
    {
        $email = 'duplikat.'.uniqid().'@gmail.com';

        User::create([
            'name' => 'Sudah Ada',
            'username' => 'sudahada'.uniqid(),
            'email' => $email,
            'password_hash' => bcrypt('rahasia'),
            'role' => 'mentor',
            'status' => 'aktif',
        ]);

        $response = $this->post('/registrasi', [
            'name' => 'Pendaftar Baru',
            'email' => $email,
            'role' => 'client',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registrasi_manual_validasi_password_min_8(): void
    {
        $response = $this->post('/registrasi', [
            'name' => 'User Pendek',
            'email' => 'pendek.'.uniqid().'@gmail.com',
            'role' => 'mentor',
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
