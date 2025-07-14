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
        Schema::create('ebps_map_pass_group_map_step', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_step_id')->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->foreignId('map_pass_group_id')->constrained('ebps_map_pass_groups')->cascadeOnDelete();
            $table->string('type');
            $table->integer('position')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_pass_group_map_step');
    }
};
