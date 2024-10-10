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
        Schema::create('ride_daily', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');  // Column for start time
            $table->time('complete_time');  // Column for complete time
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade');  // Foreign key referencing rides table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_dailies');
    }
};
