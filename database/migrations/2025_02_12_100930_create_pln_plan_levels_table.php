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
        Schema::create('pln_plan_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_level_id')->nullable()->constrained('pln_plan_levels')->cascadeOnDelete();
            $table->string('level_name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_plan_levels');
    }
};
