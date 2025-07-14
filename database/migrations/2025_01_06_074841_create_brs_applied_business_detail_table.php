<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_applied_business_detail', function (Blueprint $table) {
            $table->id();
            $table->string('submission_no')->nullable();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years', 'id')->nullOnDelete();
            $table->string('registration_no')->nullable();
            $table->string('registration_date_ne')->nullable();
            $table->string('registration_date_en')->nullable();
            $table->string('business_title');
            $table->text('business_purpose')->nullable();
            $table->foreignId('business_province_id')->nullable()->constrained('add_provinces', 'id');
            $table->foreignId('business_district_id')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('business_local_body_id')->nullable()->constrained('add_local_bodies', 'id');
            $table->string('business_ward_no')->nullable();
            $table->string('way')->nullable();
            $table->string('tole')->nullable();
            $table->foreignId('business_nature_id')->nullable()->constrained('brs_business_natures', 'id');
            $table->foreignId('business_offering_id')->nullable()->constrained('brs_business_offerings', 'id');
            $table->double('working_capital', 12, 2)->nullable()->default(0);
            $table->double('fixed_capital', 12, 2)->nullable()->default(0);
            $table->double('investment', 12, 2)->default(0);
            $table->boolean('is_rent')->default(0);
            $table->string('house_owner_name')->nullable();
            $table->string('house_owner_phone')->nullable();
            $table->string('house_owner_address')->nullable();
            $table->string('house_owner_monthly_rent')->nullable();
            $table->string('business_area_length')->nullable();
            $table->string('business_area_width')->nullable();
            $table->string('application_date')->nullable();
            $table->string('application_date_en')->nullable();
            $table->string('rent_agreement_document')->nullable();
            $table->string('land_ownership_certificate')->nullable();
            $table->string('ward_recommendation')->nullable();
            $table->string('embassy_document')->nullable();
            $table->string('business_registration_document')->nullable();
            $table->string('business_license_document')->nullable();
            $table->string('business_tax_document')->nullable();

            $table->string('bill_no')->nullable();
            $table->string('bill_date_bs')->nullable();
            $table->string('bill_date_ad')->nullable();
            $table->string('other_file')->nullable();
            $table->double('amount', 12, 2)->nullable()->default(0);
            $table->string('taxpayer_number')->nullable();

            $table->integer('reg_no')->default(0);

            // $table->foreignId('mobile_user_id')->nullable()->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_applied_business_detail');
    }
};
