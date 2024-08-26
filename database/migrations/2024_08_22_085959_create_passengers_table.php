<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('male');
            $table->string('age')->nullable();
            $table->string('nic_no')->nullable();
            $table->text('profile_image')->nullable();
            $table->text('fcm_token')->nullable();
            $table->string('language_code')->default('en');
            $table->text('about_me')->nullable();
            $table->string('interests')->nullable();
            $table->string('ride_preference')->nullable();
            $table->string('preferred_vehicle')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
