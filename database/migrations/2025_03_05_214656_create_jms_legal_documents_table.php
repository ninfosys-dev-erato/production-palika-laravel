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
        Schema::create('jms_legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->foreignId('party_name')->constrained('jms_parties')->cascadeOnDelete();
            $table->string('party_name')->nullable(); // वकपत्र गर्नेको नाम
            $table->string('document_writer_name')->nullable(); // वकपत्र लेख्नेको नाम
            $table->string('document_date')->nullable(); // वकपत्र मिति
            $table->text('document_details')->nullable(); // वकपत्रको व्यहोरा
            $table->text('template')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_legal_documents');
    }
};
