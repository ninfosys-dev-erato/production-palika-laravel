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
        Schema::create('ebps_distance_to_walls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_id')->nullable()->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->string('direction')->nullable();
            $table->boolean('has_road')->nullable();
            $table->boolean('does_have_wall_door')->nullable();
            $table->string('dist_left')->nullable();
            $table->string('min_dist_left')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_distance_to_walls');
    }
};
