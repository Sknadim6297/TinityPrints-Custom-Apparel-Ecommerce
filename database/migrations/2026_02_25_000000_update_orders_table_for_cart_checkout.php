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
            // Add user_id to link order to authenticated user
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            
            // Add order totals
            $table->decimal('subtotal', 10, 2)->default(0)->after('quantity');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total_amount', 10, 2)->default(0)->after('discount_amount');
            
            // Add payment method
            $table->enum('payment_method', ['cod', 'online', 'bank_transfer'])->default('cod')->after('payment_status');
            
            // Add coupon code if applied
            $table->string('coupon_code')->nullable()->after('payment_method');
            
            // Make some fields nullable for cart-based orders
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->string('product_size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'subtotal',
                'discount_amount',
                'total_amount',
                'payment_method',
                'coupon_code'
            ]);
        });
    }
};
