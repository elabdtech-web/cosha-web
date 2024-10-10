<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade'); // Foreign key to the rides table
            $table->foreignId('passenger_id')->constrained('passengers')->onDelete('cascade'); // Foreign key to the passengers table
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade'); // Foreign key to the drivers table
            $table->integer('rating')->unsigned(); // Rating (Assumed as an integer value between 1-5)
            $table->text('review')->nullable(); // Optional text review
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
