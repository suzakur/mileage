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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_name');
            $table->string('card_type'); // visa, mastercard, amex, jcb, unionpay
            $table->string('card_level'); // classic, gold, platinum, infinite, world
            $table->string('card_number_masked'); // **** **** **** 1234
            $table->string('bank_name');
            $table->string('card_color')->default('#1a305f'); // gradient color
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('available_credit', 15, 2)->default(0);
            $table->integer('reward_points')->default(0);
            $table->decimal('miles_earned', 12, 2)->default(0);
            $table->date('expiry_date');
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('active'); // active, blocked, expired
            $table->json('benefits')->nullable(); // array of benefits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
