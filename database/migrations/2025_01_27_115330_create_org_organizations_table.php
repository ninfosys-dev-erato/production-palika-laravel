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
        Schema::create('org_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('org_name_ne');
            $table->string('org_name_en')->nullable();
            $table->string('org_email')->nullable();
            $table->string('org_contact')->nullable();
            $table->string('org_registration_no')->nullable();
            $table->string('org_registration_date')->nullable();
            $table->string('org_registration_document')->nullable();
            $table->string('documents')->nullable();
            $table->string('org_pan_no')->nullable();
            $table->string('org_pan_registration_date')->nullable();
            $table->string('org_pan_document')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('district_id')->nullable()->constrained('add_districts');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies');
            $table->integer('ward')->nullable();
            $table->string('tole')->nullable();
            $table->string('local_body_registration_date')->nullable();
            $table->string('local_body_registration_no')->nullable();
            $table->string('company_registration_document')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_organization')->default(1);
            $table->boolean('can_work')->default(0);
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_organizations');
    }
};
