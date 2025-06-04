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
            $table->string('name');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('network', ['Visa', 'MasterCard', 'Amex', 'JCB', 'UnionPay']);
            $table->enum('type', ['Debit', 'Credit', 'Charge', 'QRIS']);
            $table->enum('tier', ['Classic', 'Silver', 'Gold', 'Platinum', 'Signature', 'Infinite', 'Standard', 'World', 'World Elite', 'Green', 'The Class', 'International']);
            $table->enum('class', ['Starter', 'Middle', 'Upper', 'Elite', 'Supreme']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('card_number', 6)->unique();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
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