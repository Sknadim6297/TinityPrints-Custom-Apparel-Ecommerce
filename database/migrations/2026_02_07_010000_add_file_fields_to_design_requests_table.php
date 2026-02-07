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
            $table->string('file_format')->nullable()->after('design_file_path');
            $table->unsignedInteger('dpi')->nullable()->after('file_format');
            $table->decimal('print_width', 8, 2)->nullable()->after('dpi');
            $table->decimal('print_height', 8, 2)->nullable()->after('print_width');
            $table->string('print_unit')->default('in')->after('print_height');
            $table->boolean('file_locked')->default(false)->after('print_unit');
            $table->string('file_checksum')->nullable()->after('file_locked');
            $table->timestamp('file_updated_at')->nullable()->after('file_checksum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_requests', function (Blueprint $table) {
            $table->dropColumn([
                'file_format',
                'dpi',
                'print_width',
                'print_height',
                'print_unit',
                'file_locked',
                'file_checksum',
                'file_updated_at',
            ]);
        });
    }
};
