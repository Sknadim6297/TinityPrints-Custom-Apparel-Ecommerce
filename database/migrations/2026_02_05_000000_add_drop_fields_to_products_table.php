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
        Schema::table('products', function (Blueprint $table) {
            $table->string('drop_name')->nullable()->after('drop_month');
            $table->text('drop_story')->nullable()->after('drop_name');
            $table->timestamp('drop_start_at')->nullable()->after('drop_story');
            $table->timestamp('drop_end_at')->nullable()->after('drop_start_at');
            $table->integer('quantity_limit')->nullable()->after('stock_limit');
            $table->boolean('countdown_enabled')->default(false)->after('quantity_limit');
            $table->boolean('auto_hide_out_of_stock')->default(false)->after('countdown_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'drop_name',
                'drop_story',
                'drop_start_at',
                'drop_end_at',
                'quantity_limit',
                'countdown_enabled',
                'auto_hide_out_of_stock',
            ]);
        });
    }
};
