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
        Schema::create('pln_projects', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no');
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->string('project_name');
            $table->foreignId('plan_area_id')->nullable()->constrained('pln_plan_areas')->nullOnDelete();
            $table->string('project_status');
            $table->string('project_start_date')->nullable();
            $table->string('project_completion_date')->nullable();
            $table->foreignId('plan_level_id')->nullable()->constrained('pln_plan_levels')->nullOnDelete();
            $table->string('ward_no')->nullable();
            $table->double('allocated_amount', 12, 2)->default(0);
            $table->string('project_venue')->nullable();
            $table->double('evaluation_amount', 12, 2)->default(0);
            $table->string('purpose')->nullable();
            $table->string('operated_through')->nullable();
            $table->double('progress_spent_amount', 12, 2)->default(0);
            $table->double('physical_progress_target', 12, 2)->default(0);
            $table->double('physical_progress_completed', 12, 2)->default(0);
            $table->string('physical_progress_unit')->nullable();
            $table->double('first_quarterly_amount', 12, 2)->default(0);
            $table->double('first_quarterly_goal', 12, 2)->default(0);
            $table->double('second_quarterly_amount', 12, 2)->default(0);
            $table->double('second_quarterly_goal', 12, 2)->default(0);
            $table->double('third_quarterly_amount', 12, 2)->default(0);
            $table->double('third_quarterly_goal', 12, 2)->default(0);
            $table->double('agencies_grants', 12, 2)->default(0);
            $table->double('share_amount', 12, 2)->default(0);
            $table->double('committee_share_amount', 12, 2)->default(0);
            $table->double('labor_amount', 12, 2)->default(0);
            $table->double('benefited_organization', 12, 2)->default(0);
            $table->double('others_benefited', 12, 2)->default(0);
            $table->foreignId('expense_head_id')->nullable()->constrained('pln_expense_heads')->nullOnDelete();
            $table->double('contingency_amount', 12, 2)->default(0);
            $table->double('other_taxes', 12, 2)->default(0);
            $table->boolean('is_contracted')->default(0);
            $table->string('contract_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_projects');
    }
};
