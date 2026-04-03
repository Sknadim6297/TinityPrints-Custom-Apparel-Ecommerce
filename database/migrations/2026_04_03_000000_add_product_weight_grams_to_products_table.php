<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'product_weight_grams')) {
                $table->unsignedInteger('product_weight_grams')->default(250)->after('base_price');
            }
        });

        if (Schema::hasColumn('products', 'product_weight_grams')) {
            DB::table('products')
                ->whereNull('product_weight_grams')
                ->update(['product_weight_grams' => 250]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_weight_grams')) {
                $table->dropColumn('product_weight_grams');
            }
        });
    }
};