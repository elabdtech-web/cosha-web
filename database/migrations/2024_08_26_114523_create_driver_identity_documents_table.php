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
        Schema::create('driver_identity_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained();
            $table->string('given_name');
            $table->string('surname');
            $table->string('document_number');
            $table->string('issued_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->text('front_image');
            $table->text('back_image')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_identity_documents');
    }
};
