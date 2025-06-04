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
        Schema::create('card_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('annual_fee');
            $table->integer('suplement_fee');
            $table->double('rate');
            $table->string('penalty_fee');
            $table->string('late_fee');
            $table->string('admin_fee');
            $table->string('advance_cash_fee');
            $table->integer('replacement_fee');
            $table->integer('minimum_limit')->default(0);
            $table->integer('maximum_limit');
            $table->integer('minimum_salary')->default(3000000);
            $table->integer('maximum_age')->default(21);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_specs');
    }
};
