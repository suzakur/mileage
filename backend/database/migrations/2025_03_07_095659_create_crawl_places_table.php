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
        Schema::create('crawl_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('google_place_id')->unique();
            $table->decimal('rating', 3, 1)->nullable();
            $table->integer('user_ratings_total')->nullable();
            $table->json('opening_hours')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('place_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawl_places');
    }
};
