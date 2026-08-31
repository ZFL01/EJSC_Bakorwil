<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_about_page_displays_kegiatan_from_database(): void
    {
        Kegiatan::create([
            'judul_kegiatan' => 'Workshop AI untuk Pemula',
            'tanggal_kegiatan' => now()->addDays(7)->toDateString(),
            'deskripsi' => 'Pengenalan konsep dasar AI.',
            'lokasi' => 'Ruang Pelatihan',
            'status' => 'akan_datang',
            'is_public' => true,
        ]);

        $response = $this->get('/tentang-kami');

        $response->assertOk();
        $response->assertSee('Workshop AI untuk Pemula');
        $response->assertSee('Ruang Pelatihan');
    }
}
