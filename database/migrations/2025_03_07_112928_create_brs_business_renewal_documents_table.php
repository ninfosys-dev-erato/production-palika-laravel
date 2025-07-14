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
        Schema::create('brs_business_renewal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_registration_id')->nullable()->constrained('brs_business_registration')->cascadeOnDelete();
            $table->foreignId('business_renewal')->nullable()->constrained('brs_business_renewals')->cascadeOnDelete();
            $table->string('document_name')->nullable();
            $table->string('document')->nullable();
            $table->string('document_details')->nullable();
            $table->string('document_status')->default('requested');
            $table->string('comment_log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brs_business_renewal_documents');
    }
};
