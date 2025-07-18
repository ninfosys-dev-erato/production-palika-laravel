<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_business_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years', 'id')->cascadeOnDelete();
            $table->foreignId('business_registration_id')->constrained('brs_business_registration', 'id')->cascadeOnDelete();
            $table->string('renew_date')->nullable();
            $table->string('renew_date_en')->nullable();
            $table->string('date_to_be_maintained')->nullable();
            $table->string('date_to_be_maintained_en')->nullable();
            $table->double('renew_amount', 14, 2)->nullable();
            $table->double('penalty_amount', 14, 2)->default(0);
            $table->string('payment_receipt')->nullable();
            $table->string('payment_receipt_date')->nullable();
            $table->string('payment_receipt_date_en')->nullable();
            $table->string('application_status')->nullable();
            $table->integer('reg_no')->default(0);
            $table->string('registration_no');
            $table->string('bill_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_business_renewals');
    }
};
