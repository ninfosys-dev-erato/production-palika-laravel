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
        Schema::create('pln_project_bid_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->double('cost_estimation', 12, 2)->default(0);
            $table->string('notice_published_date')->nullable();
            $table->string('newspaper_name')->nullable();
            $table->string('contract_evaluation_decision_date')->nullable();
            $table->string('intent_notice_publish_date')->nullable();
            $table->string('contract_newspaper_name')->nullable();
            $table->string('contract_acceptance_decision_date')->nullable();
            $table->double('contract_percentage', 12, 2)->default(0);
            $table->string('contractor_name')->nullable();
            $table->string('contractor_address')->nullable();
            $table->string('contractor_phone')->nullable();
            $table->string('confession_number')->nullable();
            $table->string('contract_agreement_date')->nullable();
            $table->string('contract_assigned_date')->nullable();
            $table->double('bid_bond_amount', 12, 2)->default(0);
            $table->string('bid_bond_no')->nullable();
            $table->string('bid_bond_bank_name')->nullable();
            $table->string('bid_bond_issue_date')->nullable();
            $table->string('bid_bond_expiry_date')->nullable();
            $table->string('performance_bond_no')->nullable();
            $table->double('performance_bond_amount', 12, 2)->nullable();
            $table->string('performance_bond_bank')->nullable();
            $table->string('performance_bond_issue_date')->nullable();
            $table->string('performance_bond_expiry_date')->nullable();
            $table->string('performance_bond_extended_date')->nullable();
            $table->string('insurance_issue_date')->nullable();
            $table->string('insurance_expiry_date')->nullable();
            $table->string('insurance_extended_date')->nullable();
            $table->string('bid_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_bid_details');
    }
};
