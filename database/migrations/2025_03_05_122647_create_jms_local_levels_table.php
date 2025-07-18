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
    Schema::create('jms_local_levels', function (Blueprint $table) {
        $table->id();
        $table->string('title'); //enum
        $table->string('short_title')->nullable();
        $table->string('type')->nullable();
        $table->foreignId('province_id')->nullable()->constraints('tbl_provinces')->cascadeOnDelete();
        $table->foreignId('district_id')->nullable()->constraints('tbl_districts')->cascadeOnDelete();
        $table->foreignId('local_body_id')->nullable()->constraints('tbl_local_bodies')->cascadeOnDelete();
        $table->string('mobile_no')->nullable();
        $table->string('email')->nullable();
        $table->string('website')->nullable();
        $table->string('position')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('jms_local_levels');
}
};