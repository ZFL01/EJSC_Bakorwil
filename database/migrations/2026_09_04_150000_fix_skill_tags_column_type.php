<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fix: kolom skill_tags (talenta) dan expertise_tags (mentor) di database
     * bertipe text[] (array PostgreSQL), tapi Laravel's array cast menggunakan
     * format JSON. Ubah ke text agar konsisten.
     */
    public function up(): void
    {
        // Ubah skill_tags dari text[] ke text
        DB::statement('ALTER TABLE talenta ALTER COLUMN skill_tags TYPE text USING skill_tags::text');

        // Ubah expertise_tags dari text[] ke text
        DB::statement('ALTER TABLE mentor ALTER COLUMN expertise_tags TYPE text USING expertise_tags::text');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE talenta ALTER COLUMN skill_tags TYPE text[] USING skill_tags::text[]');
        DB::statement('ALTER TABLE mentor ALTER COLUMN expertise_tags TYPE text[] USING expertise_tags::text[]');
    }
};
