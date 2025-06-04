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
        Schema::create('card_perk_location_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_perk_id')->constrained()->onDelete('cascade'); // Refers to card_perks
            $table->foreignId('place_id')->constrained()->onDelete('cascade');
            $table->timestamp('changed_at')->useCurrent(); // Timestamp when the change happened
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_perk_location_histories');
    }
};
