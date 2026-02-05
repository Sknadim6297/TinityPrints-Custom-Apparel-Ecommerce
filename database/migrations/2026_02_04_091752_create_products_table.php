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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['t-shirt', 'accessories']);
            $table->enum('fit_type', ['normal', 'slight_oversize']);
            $table->enum('sleeve_type', ['full', 'half']);
            $table->decimal('base_price', 10, 2);
            $table->boolean('is_limited_edition')->default(false);
            $table->string('drop_month')->nullable();
            $table->integer('stock_limit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
