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
        Schema::create('ebps_roads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_id')->nullable()->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->string('direction')->nullable();
            $table->string('width')->nullable();
            $table->string('dist_from_middle')->nullable();
            $table->string('min_dist_from_middle')->nullable();
            $table->string('dist_from_side')->nullable();
            $table->string('min_dist_from_side')->nullable();
            $table->string('dist_from_right')->nullable();
            $table->string('min_dist_from_right')->nullable();
            $table->string('setback')->nullable();
            $table->string('min_setback')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_roads');
    }
};
