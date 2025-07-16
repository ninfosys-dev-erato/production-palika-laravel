<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brs_business_deregistration_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brs_registration_data_id')->nullable();
            $table->string('fiscal_year')->nullable();
            $table->string('application_date')->nullable();
            $table->string('application_date_en')->nullable();
            $table->string('amount')->nullable();
            $table->string('application_rejection_reason')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('registration_number')->nullable();
            $table->json('data')->nullable();
            $table->string('application_status')->nullable();
            $table->string('bill')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('registration_type_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->string('rejected_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brs_business_deregistration_data');
    }
};
