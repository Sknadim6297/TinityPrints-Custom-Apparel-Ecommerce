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
            // Make design_file_path nullable since we now use front_design_file and back_design_file
            $table->string('design_file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_requests', function (Blueprint $table) {
            // Revert to NOT NULL (but this may fail if there are null values)
            $table->string('design_file_path')->nullable(false)->change();
        });
    }
};
