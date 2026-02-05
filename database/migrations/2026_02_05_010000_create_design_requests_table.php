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
        Schema::create('design_requests', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email');
            $table->string('selected_size');
            $table->string('design_file_path');
            $table->string('front_label')->nullable();
            $table->string('back_label')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'changes_requested'])->default('pending');
            $table->text('remarks')->nullable();
            $table->boolean('payment_unlocked')->default(false);
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_requests');
    }
};
