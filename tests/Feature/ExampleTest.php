<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Concerns\UsesPostgresTestDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // Memakai DB dev (hasil import SQL) seperti test fitur lain, bukan sqlite
    // in-memory: tabel legacy seperti `project` hanya ada di DB dev sehingga
    // migrasi sqlite gagal (mis. 2026_09_17_000001_add_link_to_projects_table).
    use DatabaseTransactions, UsesPostgresTestDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
