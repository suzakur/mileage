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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('fullname')->unique();
            $table->string('phone')->unique();
            $table->string('website');
            $table->string('logo')->nullable();
            $table->string('cycle', 2)->nullable();  // Menyimpan angka tanggal
            $table->string('due', 2)->nullable();  // Menyimpan angka tanggal
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
