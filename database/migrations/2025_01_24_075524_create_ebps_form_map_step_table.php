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
        Schema::create('ebps_form_map_step', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('mst_forms')->cascadeOnDelete();
            $table->foreignId('map_step_id')->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->boolean('can_be_null')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_form_map_step');
    }
};
