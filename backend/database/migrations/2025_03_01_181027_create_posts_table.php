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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('cascade'); // Author
            $table->foreignId('card_id')->nullable()->constrained()->onDelete('cascade'); // Card
            $table->foreignId('page_id')->constrained()->onDelete('cascade'); // Page
            $table->foreignId('merchant_place_id')->constrained()->onDelete('cascade'); // Page
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Short summary
            $table->longText('content'); // Full post content
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('campaign')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->json('seo_meta')->nullable(); // SEO title, description, keywords
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
}; 