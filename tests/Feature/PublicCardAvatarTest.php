<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

/**
 * Avatar kartu di halaman publik (talenta, mentor, client):
 *
 * - Belum ada foto  -> tetap inisial nama (mis. "Raihan Algifari" -> "RA")
 * - Sudah ada foto  -> gambar hasil upload yang tampil di kartu
 *
 * Sumber foto: kolom foto pada tabel profil (talenta.foto / mentor.foto /
 * client.foto_logo) dan fallback ke foto profil akun (users.profile_photo).
 * Bila file-nya sudah tidak ada di storage, kartu kembali ke inisial
 * (tidak ada <img> yang rusak).
 */
class PublicCardAvatarTest extends TestCase
{
    // Pakai PostgreSQL asli (DB hasil import SQL); perubahan di-rollback otomatis.
    use DatabaseTransactions, UsesPostgresTestDatabase;

    /** File gambar dummy yang dibuat test ini (dihapus lagi di tearDown). */
    private array $photoFiles = [];

    protected function tearDown(): void
    {
        foreach ($this->photoFiles as $file) {
            Storage::disk('public')->delete($file);
        }

        parent::tearDown();
    }

    private function user(string $role, string $prefix, ?string $profilePhoto = null): User
    {
        return User::create([
            'name' => 'Uji '.$prefix,
            'username' => $prefix.uniqid(),
            'email' => $prefix.uniqid().'@gmail.com',
            'password_hash' => bcrypt('rahasia'),
            'role' => $role,
            'status' => 'aktif',
            'profile_photo' => $profilePhoto,
        ]);
    }

    /**
     * Buat file gambar dummy di disk publik (seperti hasil upload) dan
     * daftarkan supaya otomatis dihapus setelah test.
     */
    private function upload(string $directory): string
    {
        $path = $directory.'/uji-avatar-'.uniqid().'.jpg';

        Storage::disk('public')->put($path, 'gambar-uji');

        $this->photoFiles[] = $path;

        return $path;
    }

    public function test_kartu_talenta_masih_pakai_inisial_bila_belum_ada_foto(): void
    {
        $user = $this->user('talenta', 'kartutalenta');

        Talent::create([
            'id_user' => $user->id_user,
            'nama' => 'Xenofon Zulkarnain',
            'keahlian' => 'Pemrograman',
            'status' => 'aktif',
        ]);

        $response = $this->get(route('talenta', ['search' => 'Xenofon Zulkarnain']));

        $response->assertOk();
        $response->assertSee('Xenofon Zulkarnain');

        // Tanpa foto: inisial "XZ" yang dirender di kontainer avatar.
        $this->assertMatchesRegularExpression(
            '/talenta-avatar[\s\S]{0,400}?>\s*XZ\s*<\/div>/',
            $response->getContent()
        );
    }

    public function test_kartu_talenta_menampilkan_foto_yang_diupload(): void
    {
        $user = $this->user('talenta', 'fototalenta');

        $foto = $this->upload('talent/foto');

        Talent::create([
            'id_user' => $user->id_user,
            'nama' => 'Foto Talenta Uji',
            'keahlian' => 'Pemrograman',
            'foto' => $foto,
            'status' => 'aktif',
        ]);

        $response = $this->get(route('talenta', ['search' => 'Foto Talenta Uji']));

        $response->assertOk();

        // Gambar dirender di dalam kontainer avatar kartu.
        $this->assertMatchesRegularExpression(
            '/talenta-avatar[\s\S]{0,500}?<img\s+src="[^"]*'.preg_quote($foto, '/').'"/',
            $response->getContent()
        );
    }

    public function test_kartu_mentor_pakai_foto_profil_akun_bila_foto_mentor_kosong(): void
    {
        $foto = $this->upload('profiles');

        $user = $this->user('mentor', 'fotomentor', $foto);

        Mentor::create([
            'id_user' => $user->id_user,
            'nama' => 'Mentor Fallback Uji',
            'keahlian' => 'Teknologi',
            'status' => 'aktif',
        ]);

        $response = $this->get(route('mentor', ['search' => 'Mentor Fallback Uji']));

        $response->assertOk();
        $response->assertSee($foto, false);
    }

    public function test_kartu_talenta_pakai_url_avatar_absolut_dari_akun(): void
    {
        // Akun hasil login Google menyimpan URL avatar absolut (bukan path
        // storage) di users.profile_photo.
        $avatar = 'https://lh3.googleusercontent.com/a/contoh-avatar-uji=s96-c';

        $user = $this->user('talenta', 'avatarurl', $avatar);

        Talent::create([
            'id_user' => $user->id_user,
            'nama' => 'Avatar Google Uji',
            'keahlian' => 'Pemrograman',
            'status' => 'aktif',
        ]);

        $response = $this->get(route('talenta', ['search' => 'Avatar Google Uji']));

        $response->assertOk();
        $response->assertSee($avatar, false);
    }

    public function test_kartu_client_menampilkan_logo_yang_diupload(): void
    {
        $user = $this->user('client', 'logoclient');

        $logo = $this->upload('client/logo');

        Client::create([
            'id_user' => $user->id_user,
            'nama_ukm' => 'UMKM Logo Uji',
            'nama_produk' => 'Produk Logo Uji',
            'foto_logo' => $logo,
            'status' => 'aktif',
        ]);

        $response = $this->get(route('client', ['search' => 'UMKM Logo Uji']));

        $response->assertOk();
        $response->assertSee($logo, false);
    }

    public function test_kartu_client_masih_pakai_inisial_bila_belum_ada_logo(): void
    {
        $user = $this->user('client', 'kartuclient');

        Client::create([
            'id_user' => $user->id_user,
            'nama_ukm' => 'Xylo Zaman',
            'nama_produk' => 'Produk Uji',
            'status' => 'aktif',
        ]);

        $response = $this->get(route('client', ['search' => 'Xylo Zaman']));

        $response->assertOk();

        $this->assertMatchesRegularExpression(
            '/client-avatar[\s\S]{0,400}?>\s*XZ\s*<\/div>/',
            $response->getContent()
        );
    }

    public function test_kartu_tidak_menampilkan_gambar_bila_file_foto_sudah_hilang(): void
    {
        $user = $this->user('talenta', 'fotohilang');

        // Path tersimpan di database, tetapi file-nya tidak ada di storage.
        $foto = 'talent/foto/tidak-ada-'.uniqid().'.jpg';

        Talent::create([
            'id_user' => $user->id_user,
            'nama' => 'Xenofon Zulkarnain',
            'keahlian' => 'Pemrograman',
            'foto' => $foto,
            'status' => 'aktif',
        ]);

        $response = $this->get(route('talenta', ['search' => 'Xenofon Zulkarnain']));

        $response->assertOk();

        // Tidak ada <img> ke file yang tidak ada -> kembali ke inisial.
        $response->assertDontSee($foto, false);

        $this->assertMatchesRegularExpression(
            '/talenta-avatar[\s\S]{0,400}?>\s*XZ\s*<\/div>/',
            $response->getContent()
        );
    }
}
