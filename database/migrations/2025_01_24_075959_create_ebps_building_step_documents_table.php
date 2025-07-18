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
        Schema::create('ebps_building_step_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('map_step_id')->nullable()->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_building_step_documents');
    }
};
