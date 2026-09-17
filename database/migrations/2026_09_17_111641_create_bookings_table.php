<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id_user')
                ->nullOnDelete();

            $table->date('booking_date');

            $table->time('start_time');
            $table->time('end_time');

            $table->string('name');

            $table->string('institution');

            $table->string('whatsapp');

            $table->unsignedInteger('participant_count');

            $table->text('purpose');

            $table->json('additional_facilities')->nullable();

            $table->string('status')->default('pending');

            $table->text('admin_note')->nullable();

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index([
                'room_id',
                'booking_date',
                'start_time',
                'end_time'
            ]);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};