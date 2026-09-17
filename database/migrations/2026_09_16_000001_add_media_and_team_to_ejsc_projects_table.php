<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ejsc_projects', function (Blueprint $table) {
            $table->string('gambar')->nullable();
            $table->json('talenta')->nullable();
            $table->json('mentor')->nullable();
            $table->json('tenaga_ahli')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ejsc_projects', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'talenta', 'mentor', 'tenaga_ahli']);
        });
    }
};
