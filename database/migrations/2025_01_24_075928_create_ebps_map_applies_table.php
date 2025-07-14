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

        Schema::create('ebps_customer_land_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('tbl_customers')->cascadeOnDelete();
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies')->cascadeOnDelete();
            $table->string('ward')->nullable();
            $table->string('tole')->nullable();
            $table->string('area_sqm')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('seat_no')->nullable();
            $table->string('ownership')->nullable();
            $table->boolean('is_landlord')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ebps_map_applies', function (Blueprint $table) {
            $table->id();
            $table->string('submission_id')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('registration_no')->nullable();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('tbl_customers')->cascadeOnDelete();
            $table->foreignId('land_detail_id')->constrained('ebps_customer_land_details')->cascadeOnDelete();
            $table->foreignId('construction_type_id')->constrained('ebps_construction_types')->cascadeOnDelete();
            $table->string('usage')->nullable();
            $table->boolean('is_applied_by_customer')->default(true);
            $table->string('full_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('applied_date')->nullable();
            $table->string('signature')->nullable();
            $table->string('application_type')->nullable();
            $table->string('map_process_type')->nullable();
            $table->string('building_structure')->nullable();
            $table->foreignId('house_owner_id')->nullable()->constrained('ebps_house_owner_details')->cascadeOnDelete();
            $table->string('area_of_building_plinth')->nullable();
            $table->string('no_of_rooms')->nullable();
            $table->string('storey_no')->nullable();
            $table->string('year_of_house_built')->nullable();
            $table->foreignId('land_owner_id')->nullable()->constrained('ebps_house_owner_details')->cascadeOnDelete();
            $table->string('applicant_type');
            $table->string('mobile_no');
            $table->foreignId('province_id')->nullable()->constrained('add_provinces', 'id');
            $table->foreignId('district_id')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies', 'id');
            $table->string('ward_no')->nullable();
            $table->string('application_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_customer_land_details');
        Schema::dropIfExists('ebps_map_applies');
    }
};
