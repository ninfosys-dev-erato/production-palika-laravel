<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brs_business_registration_applicant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_registration_id')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('citizenship_number')->nullable();
            $table->string('citizenship_issued_date')->nullable();
            $table->string('citizenship_issued_district')->nullable();
            $table->string('applicant_province')->nullable();
            $table->string('applicant_district')->nullable();
            $table->string('applicant_local_body')->nullable();
            $table->string('applicant_ward')->nullable();
            $table->string('applicant_tole')->nullable();
            $table->string('applicant_street')->nullable();
            $table->string('position')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_rear')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brs_business_registration_applicant');
    }
};
