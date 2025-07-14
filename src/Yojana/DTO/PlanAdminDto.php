<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\Natures;
use Src\Yojana\Enums\PlanTypes;
use Src\Yojana\Models\Plan;

class PlanAdminDto
{
    public function __construct(
        public string $project_name,
        public string $implementation_method_id,
        public string $location,
        public string $ward_id,
        public string $start_fiscal_year_id,
        public string $operate_fiscal_year_id,
        public string $area_id,
        public string $sub_region_id,
        public string $targeted_id,
        public string $implementation_level_id,
        public PlanTypes $plan_type,
        public Natures $nature,
        public string $project_group_id,
        public string $purpose,
        public string $red_book_detail,
        public string $allocated_budget,
        public string $remaining_budget,
        public string $category,
        public ?string $department,
        //        public ?string $source_id,
        //        public ?string $program,
        //        public ?string $budget_head_id,
        //        public ?string $expense_head_id,
        //        public ?string $fiscal_year_id,
        //        public ?string $amount
    ) {}

    public static function fromLiveWireModel(Plan $plan): PlanAdminDto
    {
        return new self(
            project_name: $plan->project_name,
            implementation_method_id: $plan->implementation_method_id,
            location: $plan->location,
            ward_id: $plan->ward_id,
            start_fiscal_year_id: $plan->start_fiscal_year_id,
            operate_fiscal_year_id: $plan->operate_fiscal_year_id,
            area_id: $plan->area_id,
            sub_region_id: $plan->sub_region_id,
            targeted_id: $plan->targeted_id,
            implementation_level_id: $plan->implementation_level_id,
            plan_type: $plan->plan_type,
            nature: $plan->nature,
            project_group_id: $plan->project_group_id,
            purpose: $plan->purpose,
            red_book_detail: $plan->red_book_detail,
            allocated_budget: $plan->allocated_budget,
            remaining_budget: $plan->remaining_budget ?? $plan->allocated_budget,
            category: $plan->category,
            department: $plan->department ?? null,
            //        source_id: $plan->source_id ?? null,
            //        program: $plan->program ?? null,
            //        budget_head_id: $plan->budget_head_id ?? null,
            //        expense_head_id: $plan->expense_head_id ?? null,
            //        fiscal_year_id: $plan->fiscal_year_id ?? null,
            //        amount: $plan->amount ?? null
        );
    }
}
