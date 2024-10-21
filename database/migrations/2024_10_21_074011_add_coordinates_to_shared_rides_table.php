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
        Schema::table('shared_rides', function (Blueprint $table) {
            // Adding the new columns for latitude and longitude
            $table->string('pickup_latitude')->nullable();
            $table->string('pickup_longitude')->nullable();
            $table->string('dropoff_latitude')->nullable();
            $table->string('dropoff_longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shared_rides', function (Blueprint $table) {
            // Dropping the added columns if the migration is rolled back
            $table->dropColumn('pickup_latitude');
            $table->dropColumn('pickup_longitude');
            $table->dropColumn('dropoff_latitude');
            $table->dropColumn('dropoff_longitude');
        });
    }
};
