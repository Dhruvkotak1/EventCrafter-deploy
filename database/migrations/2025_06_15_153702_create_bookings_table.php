<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();   // Customer
        $table->foreignId('event_id')->references('id')->on('events')->cascadeOnDelete(); // Event
        $table->date('booking_date');
        $table->integer('number_of_tickets');
        $table->integer('amount_paid'); // total amount paid
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('confirmed');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
