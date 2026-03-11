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
            // Add new columns if they don't exist
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('category');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            }

            if (!Schema::hasColumn('products', 'sleeve_type_id')) {
                $table->unsignedBigInteger('sleeve_type_id')->nullable()->after('sleeve_type');
                $table->foreign('sleeve_type_id')->references('id')->on('sleeve_types')->onDelete('set null');
            }

            if (!Schema::hasColumn('products', 'collection_type_id')) {
                $table->unsignedBigInteger('collection_type_id')->nullable()->after('brand');
                $table->foreign('collection_type_id')->references('id')->on('collection_types')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'collection_type_id')) {
                $table->dropForeign(['collection_type_id']);
                $table->dropColumn('collection_type_id');
            }

            if (Schema::hasColumn('products', 'sleeve_type_id')) {
                $table->dropForeign(['sleeve_type_id']);
                $table->dropColumn('sleeve_type_id');
            }

            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};
