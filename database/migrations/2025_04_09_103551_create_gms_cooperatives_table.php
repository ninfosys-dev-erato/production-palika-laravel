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
        Schema::create('gms_cooperatives', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->foreignId('cooperative_type_id')->nullable()->constrained('gms_cooperative_types')->cascadeOnDelete();
            $table->string('registration_no')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('vat_pan')->nullable();
            $table->mediumText('objective')->nullable();
            $table->foreignId('affiliation_id')->nullable()->constrained('gms_affiliations')->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces')->cascadeOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('add_districts')->cascadeOnDelete();
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies')->cascadeOnDelete();
            $table->integer('ward_no')->nullable();
            $table->string('village')->nullable();
            $table->string('tole')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_cooperatives');
    }
};
