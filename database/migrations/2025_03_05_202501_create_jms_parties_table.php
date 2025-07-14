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
        Schema::create('jms_parties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->string('gender')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->foreignId('permanent_province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('permanent_district_id')->nullable()->constrained('add_districts');
            $table->foreignId('permanent_local_body_id')->nullable()->constrained('add_local_bodies');
            $table->string('permanent_ward_id')->nullable()->constrained('tbl_wards')->cascadeOnDelete();
            $table->string('permanent_tole')->nullable();
            $table->foreignId('temporary_province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('temporary_district_id')->nullable()->constrained('add_districts');
            $table->foreignId('temporary_local_body_id')->nullable()->constrained('add_local_bodies');
            $table->string('temporary_ward_id')->nullable()->constrained('tbl_wards')->cascadeOnDelete();
            $table->string('temporary_tole')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // $table->string('type')->nullable();
            // $table->foreignId('reg_id')->nullable()->constrained('jms_complaint_registrations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_parties');
    }
};
