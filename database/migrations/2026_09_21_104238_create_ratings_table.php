<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            // Client yang memberikan rating
            $table->unsignedBigInteger('client_id');

            // Target rating: talent atau mentor
            $table->string('rateable_type');
            $table->unsignedBigInteger('rateable_id');

            // Nilai rating 1-5
            $table->unsignedTinyInteger('rating');

            // Komentar client
            $table->text('comment')->nullable();

            $table->timestamps();

            // Index untuk mempercepat pencarian rating
            $table->index([
                'rateable_type',
                'rateable_id'
            ]);

            // Index client
            $table->index('client_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};