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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('general_notification')->default(true);
            $table->boolean('sound')->default(true);
            $table->boolean('vibrate')->default(true);
            $table->boolean('app_updates')->default(false);
            $table->boolean('promotion')->default(true);
            $table->boolean('discount_available')->default(false);
            $table->boolean('payment_request')->default(false);
            $table->boolean('push_notifications')->default(true);
            $table->boolean('new_tips_available')->default(true);
            $table->boolean('new_service_available')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
