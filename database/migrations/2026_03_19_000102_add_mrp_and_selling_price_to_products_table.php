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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'mrp')) {
                $table->decimal('mrp', 10, 2)->nullable()->after('collection_type_id');
            }

            if (!Schema::hasColumn('products', 'selling_price')) {
                $table->decimal('selling_price', 10, 2)->nullable()->after('mrp');
            }
        });

        DB::table('products')->whereNull('mrp')->update([
            'mrp' => DB::raw('base_price'),
        ]);

        DB::table('products')->whereNull('selling_price')->update([
            'selling_price' => DB::raw('base_price'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'selling_price')) {
                $table->dropColumn('selling_price');
            }

            if (Schema::hasColumn('products', 'mrp')) {
                $table->dropColumn('mrp');
            }
        });
    }
};
