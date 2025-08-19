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
        Schema::create('ebps_additional_form_dynamic_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('map_apply_id');
            $table->unsignedBigInteger('additional_form_id');
            $table->json('form_data')->nullable();
            $table->timestamps();

            $table->foreign('map_apply_id')->references('id')->on('ebps_map_applies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_additional_form_dynamic_data');
    }
};
