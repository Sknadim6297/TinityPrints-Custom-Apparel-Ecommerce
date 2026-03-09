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
        Schema::table('coupons', function (Blueprint $table) {
            // Add per-customer usage limit (how many times EACH customer can use this coupon)
            // usage_limit remains as total usage limit (how many times coupon can be used by ALL customers)
            $table->unsignedInteger('per_customer_usage_limit')->nullable()->after('usage_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('per_customer_usage_limit');
        });
    }
};
