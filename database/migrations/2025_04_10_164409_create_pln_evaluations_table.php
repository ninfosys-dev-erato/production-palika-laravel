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
        Schema::create('pln_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->nullable()->references('id')->on('pln_plans')->onDelete('cascade');
            $table->string('evaluation_date')->nullable();
            $table->string('completion_date')->nullable();
            $table->string('installment_no')->nullable();
            $table->string('up_to_date_amount')->nullable();
            $table->string('evaluation_amount')->nullable();
            $table->string('total_vat')->nullable();
            $table->string('is_implemented')->nullable();
            $table->string('is_budget_utilized')->nullable();
            $table->string('is_quality_maintained')->nullable();
            $table->string('is_reached')->nullable();
            $table->string('is_tested')->nullable();
            $table->string('testing_date')->nullable();
            $table->string('attendance_number')->nullable();
            $table->string('evaluation_no')->nullable();
            $table->string('ward_recommendation_document')->nullable();
            $table->string('technical_evaluation_document')->nullable();
            $table->string('evaluation_amount')->nullable();
            $table->string('committee_report')->nullable();
            $table->string('attendance_report')->nullable();
            $table->string('construction_progress_photo')->nullable();
            $table->string('work_completion_report')->nullable();
            $table->string('expense_report')->nullable();
            $table->string('other_document')->nullable();
            $table->string('is_vatable')->nullable();
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
        Schema::dropIfExists('pln_evaluations');
    }
};
