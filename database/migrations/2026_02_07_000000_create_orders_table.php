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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            $table->string('customer_name');
            $table->string('phone');
            $table->string('email');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->string('product_size');
            $table->unsignedInteger('quantity')->default(1);

            $table->unsignedBigInteger('design_request_id')->nullable();
            $table->enum('custom_design_status', ['pending', 'approved', 'rejected', 'changes_requested', 'not_required'])
                ->default('not_required');

            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');

            $table->enum('order_status', [
                'design_pending',
                'design_approved',
                'payment_pending',
                'paid',
                'printing',
                'packed',
                'shipped',
                'delivered',
                'refund_requested',
                'refunded',
            ])->default('design_pending');

            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->default('Pakistan');
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();

            $table->timestamps();

            $table->index('order_status');
            $table->index('payment_status');
            $table->index('custom_design_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
