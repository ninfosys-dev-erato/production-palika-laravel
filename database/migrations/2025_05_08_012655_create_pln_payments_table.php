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
        Schema::create('pln_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->nullable()->constrained('pln_plans')->cascadeOnDelete();
            $table->foreignId('evaluation_id')->nullable()->constrained('pln_evaluations')->cascadeOnDelete();
            $table->string('payment_date')->nullable();
            $table->string('estimated_cost')->nullable();
            $table->string('agreement_cost')->nullable();
            $table->string('total_paid_amount')->nullable();
            $table->string('installment')->nullable();
            $table->string('evaluation_amount')->nullable();
            $table->string('previous_advance')->nullable();
            $table->string('current_advance')->nullable();
            $table->string('previous_deposit')->nullable();
            $table->string('current_deposit')->nullable();
            $table->string('total_tax_deduction')->nullable();
            $table->string('total_deduction')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('bill_amount')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_payments');
    }
};
