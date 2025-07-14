<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_industry_registration', function (Blueprint $table) {
            $table->id();
            $table->integer('reg_no')->default(0);
            $table->string('submission_no')->nullable();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years', 'id')->nullOnDelete();
            $table->foreignId('industry_category_id')->nullable()->constrained('brs_industry_categories');
            $table->string('registration_no')->nullable();
            $table->string('registration_date_ne')->nullable();
            $table->string('registration_date_en')->nullable();
            $table->string('industry_name');
            $table->string('name_en');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('address_en');
            $table->text('purpose')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces', 'id');
            $table->foreignId('district_id')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies', 'id');
            $table->string('ward_no')->nullable();
            $table->string('way')->nullable();
            $table->string('tole')->nullable();
            $table->string('investment')->nullable();
            $table->string('working_capital')->nullable();
            $table->string('fixed_capital')->nullable();
            $table->string('electricity')->nullable();
            $table->string('production_capacity')->nullable();
            $table->string('manpower')->nullable();
            $table->string('open_date')->nullable();
            $table->string('working_days')->nullable();
            $table->string('start_date')->nullable();
            $table->string('product')->nullable();
            $table->string('application_date')->nullable();
            $table->string('application_date_en')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('bill_date_bs')->nullable();
            $table->string('bill_date_ad')->nullable();
            $table->double('amount', 12, 2)->nullable()->default(0);
            $table->string('taxpayer_number')->nullable();
            $table->string('other')->nullable();
            $table->string('other_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_industry_registration');
    }
};
