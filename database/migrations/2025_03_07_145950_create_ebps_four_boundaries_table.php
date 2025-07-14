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
        Schema::create('ebps_four_boundaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_detail_id')->nullable()->constrained('ebps_customer_land_detais')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('direction')->nullable();
            $table->string('distance')->nullable();
            $table->string('lot_no')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_four_boundaries');
    }
};
