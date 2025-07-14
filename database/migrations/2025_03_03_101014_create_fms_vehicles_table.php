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
        Schema::create('fms_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('mst_employees')->nullOnDelete();
            $table->foreignId('vehicle_category_id')->nullable()->constrained('fms_vehicle_categories')->nullOnDelete();
            $table->string('vehicle_number');
            $table->string('chassis_number');
            $table->string('engine_number');
            $table->string('fuel_type');
            $table->string('driver_name');
            $table->string('license_number');
            $table->string('license_photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('driver_contact_no');
            $table->longText('vehicle_detail');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_vehicles');
    }
};
