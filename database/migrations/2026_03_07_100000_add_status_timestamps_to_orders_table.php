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
            // Add timestamp fields for each order status
            $table->timestamp('placed_at')->nullable()->after('delivered_date');
            $table->timestamp('confirmed_at')->nullable()->after('placed_at');
            $table->timestamp('paid_at')->nullable()->after('confirmed_at');
            $table->timestamp('printing_at')->nullable()->after('paid_at');
            $table->timestamp('packed_at')->nullable()->after('printing_at');
            $table->timestamp('shipped_at')->nullable()->after('packed_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            $table->timestamp('refunded_at')->nullable()->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'placed_at',
                'confirmed_at',
                'paid_at',
                'printing_at',
                'packed_at',
                'shipped_at',
                'delivered_at',
                'cancelled_at',
                'refunded_at',
            ]);
        });
    }
};
