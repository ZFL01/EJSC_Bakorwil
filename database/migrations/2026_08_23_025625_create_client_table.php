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
        Schema::create('client', function (Blueprint $table) {
            $table->bigIncrements('id_client');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_wilayah')->nullable();
            $table->string('nama_ukm', 200);
            $table->string('foto_logo', 255)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('domisili', 150)->nullable();
            $table->string('nama_produk', 200)->nullable();
            $table->text('deskripsi_usaha')->nullable();
            $table->string('nama_pemilik', 150)->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('website', 500)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->boolean('is_public')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
