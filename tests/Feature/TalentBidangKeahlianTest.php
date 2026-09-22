<?php

namespace Tests\Feature;

use App\Models\Mentor;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

class TalentBidangKeahlianTest extends TestCase
{
    // Halaman admin & profil butuh PostgreSQL asli (DB hasil import SQL),
    // tetapi setiap perubahan di-rollback otomatis setelah test.
    use DatabaseTransactions, UsesPostgresTestDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin Bidang',
            'username' => 'adminbidang'.uniqid(),
            'email' => 'adminbidang'.uniqid().'@bakorwil.go.id',
            'password_hash' => bcrypt('rahasia'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);
    }

    public function test_pilihan_bidang_keahlian_sesuai_permintaan(): void
    {
        $this->assertSame(
            ['Desain', 'Foto', 'Keuangan', 'Pemrograman', 'Video'],
            Talent::BIDANG_KEAHLIAN_OPTIONS
        );
    }

    public function test_field_tunggal_menampilkan_semua_pilihan_bidang(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-dropdown',
            'bkValue' => null,
        ])->render();

        foreach (Talent::BIDANG_KEAHLIAN_OPTIONS as $option) {
            $this->assertStringContainsString('data-bidang-option="'.$option.'"', $html);
        }

        // Satu field saja: input "keahlian" tunggal, tanpa <select> atau
        // input tambahan di bawahnya.
        $this->assertSame(1, substr_count($html, 'name="keahlian"'));
        $this->assertSame(1, substr_count($html, '<input type="text"'));
        $this->assertStringNotContainsString('<select', $html);
        $this->assertStringNotContainsString('name="bidang_keahlian"', $html);
    }

    public function test_nilai_preset_langsung_terisi_pada_field_tunggal(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-preset',
            'bkValue' => 'Video',
        ])->render();

        $this->assertStringContainsString('value="Video"', $html);
        $this->assertSame(1, substr_count($html, 'name="keahlian"'));
    }

    public function test_nilai_lama_di_luar_preset_tetap_terisi(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-lainnya',
            'bkValue' => 'Copywriter',
        ])->render();

        // Nilai bebas tidak hilang dan tidak dipaksa jadi salah satu preset.
        $this->assertStringContainsString('value="Copywriter"', $html);
        $this->assertSame(1, substr_count($html, 'name="keahlian"'));
    }

    public function test_mapping_kategori_skill_bidang_baru(): void
    {
        foreach ([
            'Desain' => 'design',
            'Foto' => 'foto',
            'Keuangan' => 'keuangan',
            'Pemrograman' => 'programming',
            'Video' => 'video',
            'Copywriter' => 'lainnya',
            'Data Analyst' => 'data',
        ] as $keahlian => $expected) {
            $talent = new Talent(['keahlian' => $keahlian]);

            $this->assertSame($expected, Talent::skillKey($talent), "keahlian: {$keahlian}");
        }
    }

    public function test_beberapa_bidang_dirender_sebagai_chip_dalam_satu_field(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-multi',
            'bkValue' => 'Desain, Video',
        ])->render();

        // Tetap satu field: satu input teks untuk mengetik + satu input hidden
        // bernama "keahlian" yang membawa seluruh nilai.
        $this->assertSame(1, substr_count($html, 'name="keahlian"'));
        $this->assertSame(1, substr_count($html, '<input type="text"'));
        $this->assertStringNotContainsString('<select', $html);

        // Kedua bidang tampil sebagai chip dan ikut terkirim ke server.
        $this->assertSame(2, substr_count($html, 'data-bidang-value="'));
        $this->assertStringContainsString('data-bidang-value="Desain"', $html);
        $this->assertStringContainsString('data-bidang-value="Video"', $html);
        $this->assertStringContainsString('value="Desain, Video"', $html);
    }

    public function test_daftar_bidang_dinormalkan_dari_berbagai_pemisah(): void
    {
        $this->assertSame(['Desain', 'Video'], Talent::keahlianList('Desain, Video'));
        $this->assertSame(['Desain', 'video'], Talent::keahlianList(' Desain ;  video '));
        $this->assertSame(['Pemrograman'], Talent::keahlianList('Pemrograman, pemrograman'));
        $this->assertSame([], Talent::keahlianList(' , ; '));

        $this->assertSame('Desain, Video', Talent::normalizeKeahlian('Desain,Video'));
        $this->assertNull(Talent::normalizeKeahlian(';'));
    }

    public function test_satu_talenta_bisa_punya_beberapa_kategori_skill(): void
    {
        $duaBidang = new Talent(['keahlian' => 'Desain, Video']);

        $this->assertSame(['Desain', 'Video'], Talent::keahlianList($duaBidang));
        $this->assertSame(['design', 'video'], Talent::skillKeys($duaBidang));
        $this->assertSame('design', Talent::skillKey($duaBidang));

        $tigaBidang = new Talent(['keahlian' => 'Video, Keuangan, Pemrograman']);

        $this->assertSame(['programming', 'keuangan', 'video'], Talent::skillKeys($tigaBidang));
        $this->assertSame('programming', Talent::skillKey($tigaBidang));
    }

    public function test_pilihan_bidang_keahlian_mentor_sesuai_permintaan(): void
    {
        $this->assertSame(
            ['Bisnis', 'Desain', 'Pendidikan', 'Teknologi'],
            Mentor::BIDANG_KEAHLIAN_OPTIONS
        );
    }

    public function test_partial_mentor_menampilkan_saran_mentor_dan_satu_field(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-mentor',
            'bkValue' => null,
            'bkModel' => 'mentor',
        ])->render();

        foreach (Mentor::BIDANG_KEAHLIAN_OPTIONS as $option) {
            $this->assertStringContainsString('data-bidang-option="'.$option.'"', $html);
        }

        $this->assertSame(1, substr_count($html, 'name="keahlian"'));
        $this->assertSame(1, substr_count($html, '<input type="text"'));
        $this->assertStringNotContainsString('<select', $html);
    }

    public function test_beberapa_bidang_mentor_dirender_normal_dan_dimapping(): void
    {
        $html = view('partials._bidang-keahlian', [
            'bkFieldKey' => 'uji-mentor-multi',
            'bkValue' => 'Desain, Teknologi',
            'bkModel' => 'mentor',
        ])->render();

        // Kedua bidang tampil sebagai chip dan ikut terkirim ke server.
        $this->assertSame(2, substr_count($html, 'data-bidang-value="'));
        $this->assertStringContainsString('data-bidang-value="Desain"', $html);
        $this->assertStringContainsString('data-bidang-value="Teknologi"', $html);
        $this->assertStringContainsString('value="Desain, Teknologi"', $html);

        $mentor = new Mentor(['keahlian' => 'Desain; Teknologi,  desain ']);

        $this->assertSame(['Desain', 'Teknologi'], Mentor::keahlianList($mentor));
        $this->assertSame('Desain, Teknologi', Mentor::normalizeKeahlian($mentor));
        $this->assertSame(['teknologi', 'desain'], Mentor::bidangKeys($mentor));
        $this->assertSame('teknologi', Mentor::bidangKey($mentor));

        // Data satu bidang hasilnya sama seperti sebelum perubahan.
        $this->assertSame(['bisnis'], Mentor::bidangKeys(new Mentor(['keahlian' => 'Marketing'])));
        $this->assertSame('bisnis', Mentor::bidangKey(new Mentor(['keahlian' => 'Marketing'])));
    }
}
