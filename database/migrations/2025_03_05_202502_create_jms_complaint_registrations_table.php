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
        Schema::create('jms_complaint_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->string('reg_no')->nullable();
            $table->string('old_reg_no')->nullable();
            $table->string('reg_date')->nullable();
            $table->string('reg_address')->nullable(); //enum
            $table->foreignId('complainer_id')->nullable()->constrained('jms_parties')->cascadeOnDelete();
            $table->foreignId('defender_id')->nullable()->constrained('jms_parties')->cascadeOnDelete();
            $table->foreignId('priority_id')->nullable()->constrained('jms_priotities')->cascadeOnDelete();
            $table->foreignId('dispute_matter_id')->nullable()->constrained('jms_dispute_matters')->cascadeOnDelete();
            $table->foreignId('reconciliation_center_id')->nullable()->constrained('jms_reconciliation_centers')->cascadeOnDelete();
            $table->string('subject')->nullable();
            $table->string('reconciliation_reg_no')->nullable();
            $table->string('description')->nullable();
            $table->string('claim_request')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('jms_complaint_registrations');
    }
};
