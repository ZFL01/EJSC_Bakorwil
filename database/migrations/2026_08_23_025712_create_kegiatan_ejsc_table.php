<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kegiatan_ejsc', function (Blueprint $table) {
            $table->bigIncrements('id_kegiatan');
            $table->string('judul_kegiatan', 255);
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 500)->nullable();
            $table->date('tanggal_kegiatan');
            $table->string('status', 30)->default('akan_datang');
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->integer('max_participants')->nullable();
            $table->boolean('is_public')->default(true);
            $table->json('gallery')->nullable();
            $table->timestamps();
            
            $table->foreign('organizer_id')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_ejsc');
    }
};
