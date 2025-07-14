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
        Schema::create('pln_plans', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->foreignId('implementation_method_id')->constrained('pln_implementation_methods')->cascadeOnDelete();
            $table->string('location')->nullable();
            $table->string('ward_id')->constrained('tbl_wards')->cascadeOnDelete();
            $table->foreignId('start_fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->foreignId('operate_fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->foreignId('area_id')->constrained('pln_plan_areas')->cascadeOnDelete();
            $table->foreignId('sub_region_id')->constrained('pln_sub_regions')->cascadeOnDelete();
            $table->foreignId('targeted_id')->constrained('pln_targets')->cascadeOnDelete();
            $table->foreignId('implementation_level_id')->constrained('pln_implementation_level')->cascadeOnDelete();
            $table->string('plan_type')->nullable(); //enum (periodic, sequential)
            $table->string('nature')->nullable(); //enum (periodic, sequential)
            $table->foreignId('project_group_id')->constrained('pln_project_groups')->cascadeOnDelete();
            $table->string('purpose')->nullable();
            $table->string('red_book_detail')->nullable();
            $table->string('allocated_budget')->nullable();
            $table->foreignId('source_id')->constrained('pln_source_types')->cascadeOnDelete();
            $table->string('program')->nullable();
            $table->foreignId('budget_head_id')->constrained('pln_budget_heads')->cascadeOnDelete();
            $table->foreignId('expense_head_id')->constrained('pln_expense_heads')->cascadeOnDelete();
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->string('amount')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_plans');
    }
};
