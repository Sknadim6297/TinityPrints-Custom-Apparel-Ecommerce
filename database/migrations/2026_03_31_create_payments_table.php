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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('razorpay_payment_id')->nullable()->unique();
            $table->string('razorpay_order_id')->nullable()->unique();
            $table->string('razorpay_signature')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('INR');
            $table->string('payment_method')->nullable(); // card, upi, wallet, etc.
            $table->enum('status', ['initiated', 'pending', 'completed', 'failed', 'refunded'])->default('initiated');
            $table->text('error_message')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->timestamps();
            $table->index('razorpay_payment_id');
            $table->index('razorpay_order_id');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
