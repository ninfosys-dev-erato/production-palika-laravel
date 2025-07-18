<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_business_registration', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_type_id')->nullable()->constrained('brs_registration_types', 'id')->nullOnDelete();
            $table->string('amount')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('application_date')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('applicant_number')->nullable();
            $table->string('application_date_en')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('registration_date_en')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('certificate_number')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces', 'id');
            $table->foreignId('district_id')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies', 'id');
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years', 'id');
            $table->string('ward_no')->nullable();
            $table->string('way')->nullable();
            $table->string('tole')->nullable();
            $table->json('data')->nullable();
            $table->string('application_status')->default('pending');
            $table->string('business_status')->default('inactive');
            $table->longText('rejection_reasons')->nullable()->default(null);
            $table->timestamps();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('operator_id')->nullable()->constrained('users', 'id');
            $table->foreignId('preparer_id')->nullable()->constrained('users', 'id');
            $table->foreignId('approver_id')->nullable()->constrained('users', 'id');
            $table->foreignId('department_id')->nullable()->constrained('mst_branches', 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_business_registration');
    }
};
