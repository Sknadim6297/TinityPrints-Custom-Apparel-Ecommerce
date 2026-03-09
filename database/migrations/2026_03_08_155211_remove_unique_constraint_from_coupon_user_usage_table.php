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
        Schema::table('coupon_user_usage', function (Blueprint $table) {
            // Remove the unique constraint to allow multiple uses per customer
            $table->dropUnique(['user_id', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_user_usage', function (Blueprint $table) {
            // Restore the unique constraint
            $table->unique(['user_id', 'coupon_id']);
        });
    }
};
