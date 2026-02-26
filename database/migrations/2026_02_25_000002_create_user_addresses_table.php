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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->nullable(); // e.g., "Home", "Office", "Other"
            $table->string('full_name');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('landmark')->nullable();
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('India');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
