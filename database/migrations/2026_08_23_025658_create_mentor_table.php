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
        Schema::create('mentor', function (Blueprint $table) {
            $table->bigIncrements('id_mentor');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_wilayah')->nullable();
            $table->string('nama', 150);
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('domisili', 150)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('no_wa', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('bio')->nullable();
            $table->text('keahlian')->nullable();
            $table->text('pengalaman')->nullable();
            $table->string('portofolio_url', 500)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->boolean('is_public')->default(true);
            $table->string('url_cv', 500)->nullable();
            $table->string('url_ktp', 500)->nullable();
            $table->string('url_butap', 500)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('expertise_tags')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('jumlah_mentee')->default(0);
            $table->timestamps();
            
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor');
    }
};
