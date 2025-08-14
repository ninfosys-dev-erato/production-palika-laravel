<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brs_business_registration_data', function (Blueprint $table) {
            $table->id();
            $table->string('entity_name')->nullable();
            $table->string('fiscal_year')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('registration_type')->nullable();
            $table->unsignedBigInteger('registration_type_id')->nullable();
            $table->string('business_nature')->nullable();
            $table->string('main_service_or_goods')->nullable();
            $table->integer('total_capital')->nullable();
            $table->string('business_province')->nullable();
            $table->string('business_district')->nullable();
            $table->string('business_local_body')->nullable();
            $table->string('business_ward')->nullable();
            $table->string('business_tole')->nullable();
            $table->string('business_street')->nullable();
            $table->string('working_capital')->nullable();
            $table->string('fixed_capital')->nullable();
            $table->string('capital_investment')->nullable();
            $table->string('financial_source')->nullable();
            $table->string('required_electric_power')->nullable();
            $table->string('production_capacity')->nullable();
            $table->string('required_manpower')->nullable();
            $table->string('number_of_shifts')->nullable();
            $table->string('operation_date')->nullable();
            $table->string('others')->nullable();
            $table->string('houseownername')->nullable();
            $table->string('monthly_rent')->nullable();
            $table->string('house_owner_phone')->nullable();
            $table->string('rentagreement')->nullable();
            $table->string('east')->nullable();
            $table->string('west')->nullable();
            $table->string('north')->nullable();
            $table->string('south')->nullable();
            $table->string('landplotnumber')->nullable();
            $table->string('area')->nullable();
            $table->string('amount')->nullable();
            $table->string('application_rejection_reason')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('application_date')->nullable();
            $table->string('application_date_en')->nullable();
            $table->string('registration_date_en')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('certificate_number')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->json('data')->nullable();
            $table->string('application_status')->nullable();
            $table->string('total_running_day')->nullable();
            $table->string('is_rented')->nullable();
            $table->string('registration_category')->nullable();
            $table->string('business_status')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->string('rejected_at')->nullable();
            $table->longText('application_letter')->nullable();
            $table->longText('certificate_letter')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->unsignedBigInteger('preparer_id')->nullable();
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->timestamps();
            $table->string('business_category')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brs_business_registration_data');
    }
};
