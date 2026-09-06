<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini merupakan bagian dari migration default Laravel
     * (0001_01_01_000000_create_users_table), namun database yang
     * dipakai di-setup melalui import SQL sehingga tabel
     * `password_reset_tokens` tidak pernah dibuat. Migration khusus ini
     * menambahkan tabel tersebut untuk mendukung fitur lupa password.
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};