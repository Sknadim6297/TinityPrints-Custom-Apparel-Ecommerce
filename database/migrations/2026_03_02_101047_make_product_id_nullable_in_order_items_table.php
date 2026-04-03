<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['product_id']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE order_items MODIFY COLUMN product_id BIGINT UNSIGNED NULL');
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['product_id']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE order_items MODIFY COLUMN product_id BIGINT UNSIGNED NOT NULL');
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
