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
        Schema::create('ebps_building_registration_apply_step', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('map_step_id')->nullable()->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->foreignId('map_apply_id')->nullable()->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_building_registration_apply_step');
    }
};
