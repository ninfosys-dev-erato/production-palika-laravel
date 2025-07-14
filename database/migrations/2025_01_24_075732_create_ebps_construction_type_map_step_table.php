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
        Schema::create('ebps_construction_type_map_step', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_type_id')->constrained('ebps_construction_types')->cascadeOnDelete();
            $table->foreignId('map_step_id')->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->integer('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_construction_type_map_step');
    }
};
