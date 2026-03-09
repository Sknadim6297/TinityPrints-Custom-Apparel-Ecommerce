<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->string('email_primary')->nullable();
            $table->string('email_secondary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['email_primary', 'email_secondary']);
        });
    }
};