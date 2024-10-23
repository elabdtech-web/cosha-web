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
        Schema::create('shared_rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id'); // Reference to the ride
            $table->unsignedBigInteger('passenger_id'); // Reference to the passenger
            $table->integer('join_km'); // KM where the passenger joined the ride
            $table->integer('leave_km'); // KM where the passenger left the ride
            $table->string('status')->default('joining');
            $table->decimal('cost', 8, 2)->nullable(); // Calculated cost for the passenger
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_rides');
    }
};
