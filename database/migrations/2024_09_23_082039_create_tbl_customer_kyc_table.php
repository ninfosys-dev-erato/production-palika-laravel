<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Customers\Enums\KycStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_customer_kyc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('tbl_customers')->cascadeOnDelete();
            $table->string('date_of_birth')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->foreignId('permanent_province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('permanent_district_id')->nullable()->constrained('add_districts');
            $table->foreignId('permanent_local_body_id')->nullable()->constrained('add_local_bodies');
            $table->string('permanent_ward')->nullable();
            $table->string('permanent_tole')->nullable();
            $table->foreignId('temporary_province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('temporary_district_id')->nullable()->constrained('add_districts');
            $table->foreignId('temporary_local_body_id')->nullable()->constrained('add_local_bodies');
            $table->string('temporary_ward')->nullable();
            $table->string('temporary_tole')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->string('reason_to_reject')->nullable();
            $table->string('status')->default(KycStatusEnum::PENDING->value);
            $table->string('rejected_at')->nullable();
            $table->string('accepted_at')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_issued_date_nepali')->nullable();
            $table->string('document_issued_date_english')->nullable();
            $table->foreignId('document_issued_at')->nullable()->constrained('add_districts');
            $table->string('document_number')->nullable();
            $table->string('document_image1')->nullable();
            $table->string('document_image2')->nullable();
            $table->string('expiry_date_nepali')->nullable(); 
            $table->string('expiry_date_english')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tbl_customer_kyc_verification_logs', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('tbl_customers')->cascadeOnDelete();
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->json('old_details')->nullable();
            $table->json('new_details')->nullable();
            $table->json('old_customer_details')->nullable();
            $table->json('new_customer_details')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customer_kyc');
        Schema::dropIfExists('tbl_customer_kyc_verification_logs');
    }
};
