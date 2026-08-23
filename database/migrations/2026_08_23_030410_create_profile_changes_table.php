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
        Schema::create('profile_changes', function (Blueprint $table) {
            $table->bigIncrements('id_change');
            $table->unsignedBigInteger('id_user');
            $table->string('table_name', 100);
            $table->unsignedBigInteger('record_id');
            $table->string('field_name', 100);
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('status', 20)->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id_user')->on('users')->onDelete('set null');
            $table->index(['table_name', 'record_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_changes');
    }
};
