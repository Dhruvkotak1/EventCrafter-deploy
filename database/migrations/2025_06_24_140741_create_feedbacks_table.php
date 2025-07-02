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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreignId('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->tinyInteger('rating');
            $table->text('feedback');
            $table->timestamps();
            $table->unique(['user_id','booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
