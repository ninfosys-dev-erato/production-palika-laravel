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
        Schema::create('pln_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('activity');
            $table->boolean('is_used_for_transport')->default(0);
            $table->string('capacity');
            $table->string('speed_with_out_load');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_equipments');
    }
};
