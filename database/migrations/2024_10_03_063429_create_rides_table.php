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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->enum('type', ['daily', 'shared', 'night']);
            $table->string('pickup_location');
            $table->string('pickup_latitude');
            $table->string('pickup_longitude');
            $table->string('dropoff_location');
            $table->string('dropoff_latitude');
            $table->string('dropoff_longitude');
            $table->unsignedBigInteger('passenger_id');
            $table->decimal('estimated_price', 8, 2);
            $table->decimal('ride_price', 8, 2)->nullable();
            $table->string('status')->default('pending');
            $table->integer('no_passengers');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('vehicle_document')->nullable();
            $table->string('distance');
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
