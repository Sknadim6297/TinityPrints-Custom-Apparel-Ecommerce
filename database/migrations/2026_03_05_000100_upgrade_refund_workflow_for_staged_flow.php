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

        Schema::table('refund_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('refund_requests', 'ticket_id')) {
                $table->string('ticket_id')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('refund_requests', 'reason_code')) {
                $table->string('reason_code', 50)->nullable()->after('reason');
            }

            if (!Schema::hasColumn('refund_requests', 'description')) {
                $table->text('description')->nullable()->after('reason_code');
            }

            if (!Schema::hasColumn('refund_requests', 'evidence_path')) {
                $table->string('evidence_path')->nullable()->after('proof_path');
            }

            if (!Schema::hasColumn('refund_requests', 'product_type')) {
                $table->enum('product_type', ['normal', 'custom', 'limited'])->default('normal')->after('evidence_path');
            }

            if (!Schema::hasColumn('refund_requests', 'customer_response')) {
                $table->text('customer_response')->nullable()->after('admin_note');
            }

            if (!Schema::hasColumn('refund_requests', 'customer_response_at')) {
                $table->timestamp('customer_response_at')->nullable()->after('customer_response');
            }

            if (!Schema::hasColumn('refund_requests', 'delivery_date')) {
                $table->timestamp('delivery_date')->nullable()->after('customer_response_at');
            }

            if (!Schema::hasColumn('refund_requests', 'return_mode')) {
                $table->enum('return_mode', ['pickup_required', 'self_return'])->nullable()->after('delivery_date');
            }

            if (!Schema::hasColumn('refund_requests', 'return_initiated_at')) {
                $table->timestamp('return_initiated_at')->nullable()->after('return_mode');
            }

            if (!Schema::hasColumn('refund_requests', 'product_received_at')) {
                $table->timestamp('product_received_at')->nullable()->after('return_initiated_at');
            }

            if (!Schema::hasColumn('refund_requests', 'refund_method')) {
                $table->enum('refund_method', ['original_payment_gateway', 'wallet_refund', 'manual_transfer'])->nullable()->after('product_received_at');
            }

            if (!Schema::hasColumn('refund_requests', 'refund_amount')) {
                $table->decimal('refund_amount', 10, 2)->nullable()->after('refund_method');
            }

            if (!Schema::hasColumn('refund_requests', 'refund_completed_at')) {
                $table->timestamp('refund_completed_at')->nullable()->after('refund_amount');
            }
        });

        DB::statement("ALTER TABLE refund_requests MODIFY COLUMN status ENUM('requested','approved','rejected','paid','refund_requested','under_review','refund_approved','refund_rejected','pending_customer_response','return_in_process','product_received','refund_completed') NOT NULL DEFAULT 'requested'");

        DB::statement("UPDATE refund_requests SET reason_code = COALESCE(reason_code, 'other')");
        DB::statement('UPDATE refund_requests SET description = COALESCE(description, reason)');
        DB::statement('UPDATE refund_requests SET evidence_path = COALESCE(evidence_path, proof_path)');
        DB::statement("UPDATE refund_requests SET ticket_id = CONCAT('RFD-LEGACY-', id) WHERE ticket_id IS NULL");

        DB::statement("UPDATE refund_requests SET status = 'refund_requested' WHERE status = 'requested'");
        DB::statement("UPDATE refund_requests SET status = 'refund_approved' WHERE status = 'approved'");
        DB::statement("UPDATE refund_requests SET status = 'refund_rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE refund_requests SET status = 'refund_completed' WHERE status = 'paid'");

        DB::statement("ALTER TABLE refund_requests MODIFY COLUMN status ENUM('refund_requested','under_review','refund_approved','refund_rejected','pending_customer_response','return_in_process','product_received','refund_completed') NOT NULL DEFAULT 'refund_requested'");

        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded') NOT NULL DEFAULT 'design_pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("UPDATE refund_requests SET status = 'requested' WHERE status IN ('refund_requested','under_review','pending_customer_response','return_in_process','product_received')");
        DB::statement("UPDATE refund_requests SET status = 'approved' WHERE status = 'refund_approved'");
        DB::statement("UPDATE refund_requests SET status = 'rejected' WHERE status = 'refund_rejected'");
        DB::statement("UPDATE refund_requests SET status = 'paid' WHERE status = 'refund_completed'");

        DB::statement("UPDATE orders SET order_status = 'refund_requested' WHERE order_status IN ('under_review','refund_approved','refund_rejected')");
        DB::statement("UPDATE orders SET order_status = 'refunded' WHERE order_status IN ('return_in_process','product_received','refund_completed')");

        DB::statement("ALTER TABLE refund_requests MODIFY COLUMN status ENUM('requested','approved','rejected','paid') NOT NULL DEFAULT 'requested'");

        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','refunded') NOT NULL DEFAULT 'design_pending'");

        Schema::table('refund_requests', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_id',
                'reason_code',
                'description',
                'evidence_path',
                'product_type',
                'customer_response',
                'customer_response_at',
                'delivery_date',
                'return_mode',
                'return_initiated_at',
                'product_received_at',
                'refund_method',
                'refund_amount',
                'refund_completed_at',
            ]);
        });
    }
};
