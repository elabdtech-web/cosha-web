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
        Schema::create('ride_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id');
            $table->unsignedBigInteger('driver_id');
            $table->decimal('offered_price', 8, 2);
            $table->string('status')->default('offered')
                ->comment('offered, accepted, rejected, withdrawn');
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_offers');
    }
};
