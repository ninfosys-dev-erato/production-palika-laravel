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
        Schema::table('gms_enterprises', function (Blueprint $table) {
            $table->string('unique_id')->nullable()->change();

            // Make user_id nullable
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_enterprises', function (Blueprint $table) {
            $table->string('unique_id')->nullable(false)->change();

            // Revert user_id to non-nullable
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
