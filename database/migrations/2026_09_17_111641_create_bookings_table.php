<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id_user')
                ->nullOnDelete();

            $table->date('date');

            $table->time('time_start');
            $table->time('time_end');

            $table->string('name');

            $table->string('institution');

            $table->string('whatsapp');

            $table->unsignedInteger('participants');

            $table->text('purpose');

            $table->json('facilities')->nullable();

            $table->string('status')->default('menunggu');

            $table->text('admin_note')->nullable();

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index([
                'room_id',
                'date',
                'time_start',
                'time_end'
            ]);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};