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
        Schema::create('jms_fulfilled_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->foreignId('fulfilling_party')->constrained('jms_parties')->cascadeOnDelete(); // शर्त पुरा गर्ने पक्ष
            $table->foreignId('condition')->constrained('jms_settlement_details')->cascadeOnDelete(); // शर्त पुरा गर्ने पक्ष
            // $table->string('condition')->nullable();
            $table->string('completion_details')->nullable(); // पुरा गरेको व्यहोरा
            $table->string('completion_proof')->nullable(); // शर्त पुरा गरेको प्रमाण (file path)
            $table->string('due_date')->nullable(); // शर्त पुरा गर्नु पर्ने मिति
            $table->string('completion_date')->nullable(); // शर्त पुरा गरेको मिति
            $table->foreignId('entered_by')->constrained('jms_judicial_employees')->cascadeOnDelete(); // प्रविष्टी गर्ने अधिकारी
            $table->string('entry_date')->nullable(); // प्रविष्टि मिति
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_fulfilled_conditions');
    }
};
