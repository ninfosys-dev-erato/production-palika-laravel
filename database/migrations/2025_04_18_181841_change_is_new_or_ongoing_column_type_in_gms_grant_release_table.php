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
        Schema::table('gms_grant_release', function (Blueprint $table) {
            Schema::table('gms_grant_release', function (Blueprint $table) {
                $table->string('is_new_or_ongoing')->default('new')->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_grant_release', function (Blueprint $table) {
            $table->boolean('is_new_or_ongoing')->default(true)->change();
        });
    }
};
