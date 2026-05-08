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
        Schema::table('users', function (Blueprint $table) {
            // OAuth provider information
            $table->string('provider_name')->nullable()->after('password')->comment('OAuth provider (google, facebook)');
            $table->string('provider_id')->nullable()->after('provider_name')->comment('OAuth provider unique ID');
            $table->string('avatar')->nullable()->after('provider_id')->comment('User avatar from OAuth provider');
            $table->string('social_email')->nullable()->after('avatar')->comment('Email from OAuth provider');
            
            // Add unique constraint for provider combinations
            $table->unique(['provider_name', 'provider_id'])->comment('Ensure unique provider combinations');
            
            // Add index for faster lookups
            $table->index('provider_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['provider_name', 'provider_id']);
            $table->dropIndex(['provider_name']);
            $table->dropColumn(['provider_name', 'provider_id', 'avatar', 'social_email']);
        });
    }
};
