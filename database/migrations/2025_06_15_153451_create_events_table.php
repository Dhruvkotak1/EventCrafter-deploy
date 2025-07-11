<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete(); // Organizer
        $table->string('title');
        $table->text('description');
        $table->string('image'); // image URL
        $table->date('date');
        $table->time('time');
        $table->string('venue');
        $table->decimal('price', 10, 2);
        $table->integer('total_tickets');
        $table->integer('tickets_booked')->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
