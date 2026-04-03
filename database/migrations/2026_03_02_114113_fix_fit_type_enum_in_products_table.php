<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        // Fix fit_type enum to include all valid values
        DB::statement("ALTER TABLE products MODIFY COLUMN fit_type ENUM('regular', 'oversize', 'normal', 'slight_oversize') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Revert to original enum definition if needed
        DB::statement("ALTER TABLE products MODIFY COLUMN fit_type ENUM('regular', 'oversize') NOT NULL");
    }
};
