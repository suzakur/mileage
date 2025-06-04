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
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->index();
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->integer('referral_count')->default(0);
            $table->timestamp('subscribed_at')->nullable();
        });

        // Clean up existing data (set empty referral_code to NULL)
        DB::table('users')->where('referral_code', '')->update(['referral_code' => null]);

        // Add the unique constraint after cleaning up the data
        Schema::table('users', function (Blueprint $table) {
            $table->unique('referral_code', 'users_referral_code_unique');
        });

        // Add the foreign key constraint
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('referred_by')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['referred_by']);

            // Drop the unique constraint
            $table->dropUnique('users_referral_code_unique');

            // Drop the columns
            $table->dropColumn([
                'referral_code',
                'referred_by',
                'referral_count',
                'subscribed_at'
            ]);
        });
    }
};