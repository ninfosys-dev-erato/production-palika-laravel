<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Project;

class ProjectAdminDto
{
   public function __construct(
        public string $registration_no,
        public string $fiscal_year_id,
        public string $project_name,
        public string $plan_area_id,
        public string $project_status,
        public string $project_start_date,
        public string $project_completion_date,
        public string $plan_level_id,
        public string $ward_no,
        public string $allocated_amount,
        public string $project_venue,
        public string $evaluation_amount,
        public string $purpose,
        public string $operated_through,
        public string $progress_spent_amount,
        public string $physical_progress_target,
        public string $physical_progress_completed,
        public string $physical_progress_unit,
        public string $first_quarterly_amount,
        public string $first_quarterly_goal,
        public string $second_quarterly_amount,
        public string $second_quarterly_goal,
        public string $third_quarterly_amount,
        public string $third_quarterly_goal,
        public string $agencies_grants,
        public string $share_amount,
        public string $committee_share_amount,
        public string $labor_amount,
        public string $benefited_organization,
        public string $others_benefited,
        public string $expense_head_id,
        public string $contingency_amount,
        public string $other_taxes,
        public string $is_contracted,
        public string $contract_date
    ){}

public static function fromLiveWireModel(Project $project):ProjectAdminDto{
    return new self(
        registration_no: $project->registration_no,
        fiscal_year_id: $project->fiscal_year_id,
        project_name: $project->project_name,
        plan_area_id: $project->plan_area_id,
        project_status: $project->project_status,
        project_start_date: $project->project_start_date,
        project_completion_date: $project->project_completion_date,
        plan_level_id: $project->plan_level_id,
        ward_no: $project->ward_no,
        allocated_amount: $project->allocated_amount,
        project_venue: $project->project_venue,
        evaluation_amount: $project->evaluation_amount,
        purpose: $project->purpose,
        operated_through: $project->operated_through,
        progress_spent_amount: $project->progress_spent_amount,
        physical_progress_target: $project->physical_progress_target,
        physical_progress_completed: $project->physical_progress_completed,
        physical_progress_unit: $project->physical_progress_unit,
        first_quarterly_amount: $project->first_quarterly_amount,
        first_quarterly_goal: $project->first_quarterly_goal,
        second_quarterly_amount: $project->second_quarterly_amount,
        second_quarterly_goal: $project->second_quarterly_goal,
        third_quarterly_amount: $project->third_quarterly_amount,
        third_quarterly_goal: $project->third_quarterly_goal,
        agencies_grants: $project->agencies_grants,
        share_amount: $project->share_amount,
        committee_share_amount: $project->committee_share_amount,
        labor_amount: $project->labor_amount,
        benefited_organization: $project->benefited_organization,
        others_benefited: $project->others_benefited,
        expense_head_id: $project->expense_head_id,
        contingency_amount: $project->contingency_amount,
        other_taxes: $project->other_taxes,
        is_contracted: $project->is_contracted,
        contract_date: $project->contract_date
    );
}
}
