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
        Schema::create('ebps_map_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_public')->default(true)->nullable();
            $table->boolean('can_skip')->default(false)->nullable();
            $table->string('form_submitter')->nullable();
            $table->string('form_position')->nullable();
            $table->string('step_for')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_steps');
    }
};
