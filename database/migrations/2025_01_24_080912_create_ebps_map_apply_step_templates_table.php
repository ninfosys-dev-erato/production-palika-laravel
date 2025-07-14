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
        Schema::create('ebps_map_apply_step_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_step_id')->nullable()->constrained('ebps_map_apply_steps')->cascadeOnDelete();
            $table->foreignId('form_id')->nullable()->constrained('mst_forms')->cascadeOnDelete();
            $table->text('template')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_apply_step_templates');
    }
};
