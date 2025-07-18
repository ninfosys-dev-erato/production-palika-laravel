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
        Schema::create('jms_written_response_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('response_registration_no'); // लिखित जवाफ दर्ता नं
            // $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete(); 
            $table->foreignId('complaint_registration_id')
                ->constrained('jms_complaint_registrations', 'id')
                ->cascadeOnDelete()
                ->name('fk_written_response_complaint');
            $table->string('registration_date'); // मिति
            $table->string('fee_amount')->nullable(); // दस्तुर रकम
            $table->string('fee_receipt_no')->nullable(); // दस्तुर बुझाएको रसिद नं
            $table->string('fee_paid_date')->nullable(); // दस्तुर बुझाएको मिति
            $table->string('description')->nullable(); // संक्षिप्त विवरण
            $table->string('claim_request')->nullable(); // माग दावी
            $table->string('submitted_within_deadline')->nullable(); // म्याद भित्र रही आफैंले दर्ता गर्न ल्याएको || values in enum
            $table->string('fee_receipt_attached')->nullable(); // नियमानुसारको दस्तुर बुझाएको प्रमाण संलग्न रहेको || values in enum
            $table->boolean('status')->nullable(); //approve, reject
            $table->text('template')->nullable();
            $table->text('registration_indicator')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_written_response_registrations');
    }
};
