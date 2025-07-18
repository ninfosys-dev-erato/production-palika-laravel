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
        Schema::create('tbl_wards', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('local_body_id');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ne')->nullable();
            $table->string('ward_name_en')->nullable();
            $table->string('ward_name_ne')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_wards');
    }
};
