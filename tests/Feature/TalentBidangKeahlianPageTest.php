<?php

namespace Tests\Feature;

use App\Models\Talent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

class TalentBidangKeahlianPageTest extends TestCase
{
    // Halaman admin & profil butuh PostgreSQL asli (DB hasil import SQL),
    // tetapi setiap perubahan di-rollback otomatis setelah test.
    use DatabaseTransactions, UsesPostgresTestDatabase;

    private function user(string $role, string $prefix): User
    {
        return User::create([
            'name' => 'Uji '.$prefix,
            'username' => $prefix.uniqid(),
            'email' => $prefix.uniqid().'@gmail.com',
            'password_hash' => bcrypt('rahasia'),
            'role' => $role,
            'status' => 'aktif',
        ]);
    }

    private function talent(User $user, string $keahlian): Talent
    {
        return Talent::create([
            'id_user' => $user->id_user,
            'nama' => 'Talenta Uji',
            'no_wa' => '081234567890',
            'domisili' => 'Kec. Kaliwates, Jember',
            'alamat_lengkap' => 'Jl. Uji No. 1',
            'keahlian' => $keahlian,
            'status' => 'aktif',
        ]);
    }

    public function test_halaman_admin_tambah_talent_menampilkan_dropdown(): void
    {
        $response = $this->actingAs($this->user('admin', 'adminbidang'))
            ->get(route('admin.talents.create'));

        $response->assertOk();
        $response->assertSee('Bidang Keahlian');
        $response->assertSee('data-bidang-option="Desain"', false);
        $response->assertSee('data-bidang-option="Foto"', false);
        $response->assertSee('data-bidang-option="Keuangan"', false);
        $response->assertSee('data-bidang-option="Pemrograman"', false);
        $response->assertSee('data-bidang-option="Video"', false);

        // Hanya satu field keahlian (tidak ada field baru di bawah).
        $this->assertSame(1, substr_count($response->getContent(), 'name="keahlian"'));
    }

    public function test_halaman_admin_edit_talent_menampilkan_nilai_terpilih(): void
    {
        $admin = $this->user('admin', 'adminedit');
        $talent = $this->talent($this->user('talenta', 'talentuedit'), 'Keuangan');

        $response = $this->actingAs($admin)
            ->get(route('admin.talents.edit', $talent->id_talenta));

        $response->assertOk();
        $response->assertSee('value="Keuangan"', false);
        $response->assertSee('data-bidang-option="Keuangan"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'name="keahlian"'));
    }

    public function test_form_profil_talent_menampilkan_nilai_terpilih(): void
    {
        $user = $this->user('talenta', 'talentaprofil');
        $this->talent($user, 'Pemrograman');

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('Bidang Keahlian');
        $response->assertSee('value="Pemrograman"', false);
        $response->assertSee('data-bidang-option="Pemrograman"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'name="keahlian"'));
    }

    public function test_nilai_bebas_tetap_tersimpan_saat_update(): void
    {
        $user = $this->user('talenta', 'talentabebas');
        $talent = $this->talent($user, 'Pemrograman');

        // Wilayah wajib; ambil salah satu data wilayah yang ada.
        $talent->update(['id_wilayah' => DB::table('wilayah')->value('id_wilayah')]);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Talenta Bebas',
            'email' => $user->email,
            'nama' => 'Talenta Bebas',
            'no_wa' => '081234567899',
            'id_wilayah' => $talent->id_wilayah,
            'domisili' => 'Kec. Patrang, Jember',
            'alamat_lengkap' => 'Jl. Bebas No. 3',
            'keahlian' => 'Copywriter',
            'skill_tags' => 'Copywriting, SEO',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertSame('Copywriter', $talent->refresh()->keahlian);
    }

    public function test_admin_dapat_menyimpan_lebih_dari_satu_bidang_keahlian(): void
    {
        $email = 'multib'.uniqid().'@gmail.com';

        $admin = $this->user('admin', 'adminmulti');

        $response = $this->actingAs($admin)->post(route('admin.talents.store'), [
            'user_name' => 'Talenta Multi',
            'email' => $email,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'nama' => 'Talenta Multi',
            'no_wa' => '081234567891',
            'keahlian' => 'Desain, Video',
            'id_wilayah' => DB::table('wilayah')->value('id_wilayah'),
            'domisili' => 'Kec. Sumbersari, Jember',
            'alamat_lengkap' => 'Jl. Multi No. 1',
            'pengalaman' => '',
            'skill_tags' => 'Figma, Premiere',
            'mentor_id' => '',
            'status_pekerjaan' => 'belum bekerja',
            'url_gdrive' => '',
            'status' => 'aktif',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.talents.index'));

        // Cari lewat email agar tidak tertukar dengan data talenta lain.
        $user = User::where('email', $email)->firstOrFail();
        $talent = Talent::where('id_user', $user->id_user)->firstOrFail();

        $this->assertSame('Desain, Video', $talent->keahlian);
    }

    public function test_form_edit_admin_menampilkan_semua_chip_bidang(): void
    {
        $admin = $this->user('admin', 'adminchip');
        $talent = $this->talent($this->user('talenta', 'talentachip'), 'Desain, Video');

        $response = $this->actingAs($admin)
            ->get(route('admin.talents.edit', $talent->id_talenta));

        $response->assertOk();
        $response->assertSee('data-bidang-value="Desain"', false);
        $response->assertSee('data-bidang-value="Video"', false);
        $response->assertSee('value="Desain, Video"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'name="keahlian"'));
    }

    public function test_halaman_publik_talenta_menampilkan_semua_badge_bidang(): void
    {
        $this->talent($this->user('talenta', 'talentapublik'), 'Desain, Video');

        $response = $this->get(route('talenta'));

        $response->assertOk();

        // Kartu membawa seluruh kategori (untuk filter) dan kedua badge.
        $response->assertSee('data-kategori="design video"', false);
        $response->assertSee('data-keahlian="desain, video"', false);
        $response->assertSee('Desain, Video', false);
    }

    public function test_profil_talenta_menyimpan_banyak_bidang_keahlian(): void
    {
        $user = $this->user('talenta', 'talentamulti');
        $talent = $this->talent($user, 'Desain');

        // Wilayah wajib; ambil salah satu data wilayah yang ada.
        $talent->update(['id_wilayah' => DB::table('wilayah')->value('id_wilayah')]);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Talenta Multi',
            'email' => $user->email,
            'nama' => 'Talenta Multi',
            'no_wa' => '081234567899',
            'id_wilayah' => $talent->id_wilayah,
            'domisili' => 'Kec. Patrang, Jember',
            'alamat_lengkap' => 'Jl. Multi No. 4',
            'keahlian' => 'Video;  desain , video',
            'skill_tags' => '',
        ]);

        $response->assertSessionHasNoErrors();

        // Dipisah koma, dirapikan spasinya, dan nilai kembar dibuang.
        $this->assertSame('Video, desain', $talent->refresh()->keahlian);
    }
}
