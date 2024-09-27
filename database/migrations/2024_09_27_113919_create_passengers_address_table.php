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
        Schema::create('passengers_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passenger_id'); // Foreign key to passengers table
            $table->string('name'); // Address name
            $table->text('details')->nullable(); // Detailed address
            $table->string('longitude'); // Longitude
            $table->string('latitude'); // Latitude

            // Foreign key constraint to passengers table
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers_address');
    }
};
