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
        Schema::table('design_requests', function (Blueprint $table) {
            // Add user_id relationship if not exists
            if (!Schema::hasColumn('design_requests', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }

            // Add sleeve_type if not exists
            if (!Schema::hasColumn('design_requests', 'sleeve_type')) {
                $table->enum('sleeve_type', ['full', 'half'])->nullable()->after('selected_size');
            }

            // Add color if not exists
            if (!Schema::hasColumn('design_requests', 'color')) {
                $table->string('color')->nullable()->after('sleeve_type');
            }

            // Add separate front and back design files
            if (!Schema::hasColumn('design_requests', 'back_design_file')) {
                $table->string('back_design_file')->nullable()->after('design_file_path');
            }

            // Rename design_file_path to front_design_file for clarity
            if (Schema::hasColumn('design_requests', 'design_file_path') && !Schema::hasColumn('design_requests', 'front_design_file')) {
                $table->string('front_design_file')->nullable()->after('design_file_path');
            }

            // Add notes field
            if (!Schema::hasColumn('design_requests', 'notes')) {
                $table->text('notes')->nullable()->after('back_design_file');
            }

            // Add price field
            if (!Schema::hasColumn('design_requests', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('notes');
            }

            // Add payment_status
            if (!Schema::hasColumn('design_requests', 'payment_status')) {
                $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid')->after('price');
            }

            // Update remarks to admin_remark for clarity
            if (Schema::hasColumn('design_requests', 'remarks') && !Schema::hasColumn('design_requests', 'admin_remark')) {
                $table->text('admin_remark')->nullable()->after('remarks');
            }

            // Add order_id relationship
            if (!Schema::hasColumn('design_requests', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('payment_status');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_requests', function (Blueprint $table) {
            // Drop foreign keys
            try {
                $table->dropForeign('design_requests_user_id_foreign');
            } catch (\Exception $e) {
                // Foreign key doesn't exist
            }

            try {
                $table->dropForeign('design_requests_order_id_foreign');
            } catch (\Exception $e) {
                // Foreign key doesn't exist
            }

            // Drop columns
            $columns = ['user_id', 'sleeve_type', 'color', 'back_design_file', 'front_design_file', 'notes', 'price', 'payment_status', 'admin_remark', 'order_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('design_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
