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
        Schema::create('merchant_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('place_id')->constrained()->onDelete('cascade');
            $table->string('google_place_id')->nullable()->unique(); // Google Maps Place ID
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->enum('is_open', ['open', 'closed', 'renovation'])->default('open');
            $table->json('opening_hours')->nullable(); // Store JSON opening hours from Google
            $table->json('raw_data')->nullable(); // Store additional Google Maps data
            $table->decimal('rating', 3, 1)->nullable();
            $table->integer('user_ratings_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_places');
    }
};
