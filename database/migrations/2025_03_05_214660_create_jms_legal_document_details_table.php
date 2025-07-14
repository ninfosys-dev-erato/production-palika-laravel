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
        Schema::create('jms_legal_document_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_name')->constrained('jms_parties')->cascadeOnDelete();
            $table->string('statement_giver')->nullable(); // वकपत्र गर्नेको नाम
            $table->string('document_writer_name')->nullable(); // वकपत्र लेख्नेको नाम
            $table->string('document_date')->nullable(); // वकपत्र मिति
            $table->text('document_details')->nullable(); // वकपत्रको व्यहोरा
            $table->foreignId('legal_document_id')->constrained('jms_legal_documents')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_legal_document_details');
    }
};
