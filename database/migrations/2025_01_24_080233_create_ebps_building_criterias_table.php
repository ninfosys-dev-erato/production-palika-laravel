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
        Schema::create('ebps_building_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('min_gcr')->nullable();
            $table->string('min_far')->nullable();
            $table->string('min_dist_center')->nullable();
            $table->string('min_dist_side')->nullable();
            $table->string('min_dist_right')->nullable();
            $table->string('setback')->nullable();
            $table->string('dist_between_wall_and_boundaries')->nullable();
            $table->string('public_place_distance')->nullable();
            $table->string('cantilever_distance')->nullable();
            $table->string('high_tension_distance')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_building_criterias');
    }
};
