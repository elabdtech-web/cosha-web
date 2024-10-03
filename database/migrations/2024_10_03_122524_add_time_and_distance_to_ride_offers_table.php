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
        Schema::table('ride_offers', function (Blueprint $table) {
            $table->string('time')->after('offered_price'); // Add the 'time' column
            $table->decimal('distance', 8, 2)->after('time'); // Add the 'distance' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ride_offers', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->dropColumn('distance');
        });
    }
};
