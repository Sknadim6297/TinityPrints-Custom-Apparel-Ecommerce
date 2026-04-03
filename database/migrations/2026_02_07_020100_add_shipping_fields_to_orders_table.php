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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_partner')->nullable()->after('shipping_country');
            $table->unsignedInteger('shipping_weight_grams')->nullable()->after('shipping_partner');
            $table->decimal('shipping_cost', 10, 2)->nullable()->after('shipping_weight_grams');
            $table->enum('delivery_status', ['pending', 'shipped', 'delivered', 'failed'])->default('pending')->after('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_partner',
                'shipping_weight_grams',
                'shipping_cost',
                'delivery_status',
            ]);
        });
    }
};
