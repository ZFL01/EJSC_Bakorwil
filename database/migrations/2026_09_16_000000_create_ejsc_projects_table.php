<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejsc_projects', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('ringkasan', 500)->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->string('status')->default('rencana');
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejsc_projects');
    }
};
