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
        Schema::create('ebps_map_apply_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_id')->nullable()->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('org_organizations')->cascadeOnDelete();
            $table->foreignId('land_use_area_id')->nullable()->constrained('ebps_land_use_areas')->cascadeOnDelete();
            $table->string('land_use_area_changes')->nullable();
            $table->string('usage_changes')->nullable();
            $table->string('change_acceptance_type')->nullable();
            $table->string('field_measurement_area')->nullable();
            $table->string('building_plinth_area')->nullable();
            $table->foreignId('building_construction_type_id')->nullable()->constrained('ebps_building_construction_types')->cascadeOnDelete();
            $table->foreignId('building_roof_type_id')->nullable()->constrained('ebps_building_roof_types')->cascadeOnDelete();
            $table->string('other_construction_area')->nullable();
            $table->string('former_other_construction_area')->nullable();
            $table->string('public_property_name')->nullable();
            $table->string('material_used')->nullable();
            $table->string('distance_left')->nullable();
            $table->string('area_unit')->nullable();
            $table->string('length_unit')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_apply_details');
    }
};
