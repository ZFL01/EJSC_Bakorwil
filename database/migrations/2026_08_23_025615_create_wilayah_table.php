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
        Schema::create('wilayah', function (Blueprint $table) {
            $table->bigIncrements('id_wilayah');
            $table->string('nama_wilayah', 100);
            $table->string('jenis_wilayah', 20);
            $table->string('bakorwil', 100)->default('Bakorwil Jember');
            $table->string('kode_bps', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
