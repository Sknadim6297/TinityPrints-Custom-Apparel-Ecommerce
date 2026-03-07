<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded','cancelled') NOT NULL DEFAULT 'design_pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE orders SET order_status = 'refunded' WHERE order_status = 'cancelled'");
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded') NOT NULL DEFAULT 'design_pending'");
    }
};
