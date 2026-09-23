<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

class LoginRateLimitTest extends TestCase
{
    // Login menyentuh tabel users di PostgreSQL (DB hasil import SQL),
    // dan semua perubahan di-rollback otomatis setelah test.
    use DatabaseTransactions, UsesPostgresTestDatabase;

    /**
     * Rate limiter 'auth' harus memblokir percobaan ke-6 dari kombinasi
     * email + IP yang sama (limiter: 5 percobaan/menit per email).
     */
    public function test_login_dibatasi_setelah_5_percobaan_gagal(): void
    {
        foreach (range(1, 5) as $i) {
            $this->post('/login', [
                'email' => 'bruteforce@example.com',
                'password' => 'bukan-password',
            ]);
        }

        $this->post('/login', [
            'email' => 'bruteforce@example.com',
            'password' => 'bukan-password',
        ])->assertStatus(429);
    }

    /**
     * Email berbeda tetap boleh mencoba (bucket rate limit per email,
     * bukan per halaman) selama limit per-IP (30/menit) belum terlampaui.
     */
    public function test_email_berbeda_tidak_ikut_terblokir(): void
    {
        $this->post('/login', [
            'email' => 'target@example.com',
            'password' => 'bukan-password',
        ])->assertStatus(302);

        $this->post('/login', [
            'email' => 'pengguna-lain@example.com',
            'password' => 'bukan-password',
        ])->assertStatus(302);
    }
}
