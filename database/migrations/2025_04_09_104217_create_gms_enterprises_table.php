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
        Schema::create('gms_enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->foreignId('enterprise_type_id')->constrained('gms_enterprise_types')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('vat_pan')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces')->cascadeOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('add_districts')->cascadeOnDelete();
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies')->cascadeOnDelete();
            $table->integer('ward_no')->nullable();
            $table->string('village')->nullable();
            $table->string('tole')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_enterprises');
    }
};
