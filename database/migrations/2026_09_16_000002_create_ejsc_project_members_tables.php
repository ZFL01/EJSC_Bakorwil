<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejsc_project_talenta', function (Blueprint $table) {
            $table->foreignId('ejsc_project_id')->constrained('ejsc_projects')->cascadeOnDelete();
            $table->unsignedBigInteger('id_talenta');
            $table->unique(['ejsc_project_id', 'id_talenta']);
        });

        Schema::create('ejsc_project_mentor', function (Blueprint $table) {
            $table->foreignId('ejsc_project_id')->constrained('ejsc_projects')->cascadeOnDelete();
            $table->unsignedBigInteger('id_mentor');
            $table->unique(['ejsc_project_id', 'id_mentor']);
        });

        Schema::create('ejsc_project_tenaga_ahli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ejsc_project_id')->constrained('ejsc_projects')->cascadeOnDelete();
            $table->string('nama');
            $table->string('keahlian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejsc_project_tenaga_ahli');
        Schema::dropIfExists('ejsc_project_mentor');
        Schema::dropIfExists('ejsc_project_talenta');
    }
};
