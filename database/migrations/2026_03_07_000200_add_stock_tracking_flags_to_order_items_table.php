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
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'stock_deducted')) {
                $table->boolean('stock_deducted')->default(false)->after('total');
            }

            if (!Schema::hasColumn('order_items', 'stock_restored')) {
                $table->boolean('stock_restored')->default(false)->after('stock_deducted');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'stock_restored')) {
                $table->dropColumn('stock_restored');
            }

            if (Schema::hasColumn('order_items', 'stock_deducted')) {
                $table->dropColumn('stock_deducted');
            }
        });
    }
};
