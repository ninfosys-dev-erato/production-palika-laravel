<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectAdminDto;
use Src\Yojana\Models\Project;

class ProjectAdminService
{
public function store(ProjectAdminDto $projectAdminDto){
    return Project::create([
        'registration_no' => $projectAdminDto->registration_no,
        'fiscal_year_id' => $projectAdminDto->fiscal_year_id,
        'project_name' => $projectAdminDto->project_name,
        'plan_area_id' => $projectAdminDto->plan_area_id,
        'project_status' => $projectAdminDto->project_status,
        'project_start_date' => $projectAdminDto->project_start_date,
        'project_completion_date' => $projectAdminDto->project_completion_date,
        'plan_level_id' => $projectAdminDto->plan_level_id,
        'ward_no' => $projectAdminDto->ward_no,
        'allocated_amount' => $projectAdminDto->allocated_amount,
        'project_venue' => $projectAdminDto->project_venue,
        'evaluation_amount' => $projectAdminDto->evaluation_amount,
        'purpose' => $projectAdminDto->purpose,
        'operated_through' => $projectAdminDto->operated_through,
        'progress_spent_amount' => $projectAdminDto->progress_spent_amount,
        'physical_progress_target' => $projectAdminDto->physical_progress_target,
        'physical_progress_completed' => $projectAdminDto->physical_progress_completed,
        'physical_progress_unit' => $projectAdminDto->physical_progress_unit,
        'first_quarterly_amount' => $projectAdminDto->first_quarterly_amount,
        'first_quarterly_goal' => $projectAdminDto->first_quarterly_goal,
        'second_quarterly_amount' => $projectAdminDto->second_quarterly_amount,
        'second_quarterly_goal' => $projectAdminDto->second_quarterly_goal,
        'third_quarterly_amount' => $projectAdminDto->third_quarterly_amount,
        'third_quarterly_goal' => $projectAdminDto->third_quarterly_goal,
        'agencies_grants' => $projectAdminDto->agencies_grants,
        'share_amount' => $projectAdminDto->share_amount,
        'committee_share_amount' => $projectAdminDto->committee_share_amount,
        'labor_amount' => $projectAdminDto->labor_amount,
        'benefited_organization' => $projectAdminDto->benefited_organization,
        'others_benefited' => $projectAdminDto->others_benefited,
        'expense_head_id' => $projectAdminDto->expense_head_id,
        'contingency_amount' => $projectAdminDto->contingency_amount,
        'other_taxes' => $projectAdminDto->other_taxes,
        'is_contracted' => $projectAdminDto->is_contracted,
        'contract_date' => $projectAdminDto->contract_date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Project $project, ProjectAdminDto $projectAdminDto){
    return tap($project)->update([
        'registration_no' => $projectAdminDto->registration_no,
        'fiscal_year_id' => $projectAdminDto->fiscal_year_id,
        'project_name' => $projectAdminDto->project_name,
        'plan_area_id' => $projectAdminDto->plan_area_id,
        'project_status' => $projectAdminDto->project_status,
        'project_start_date' => $projectAdminDto->project_start_date,
        'project_completion_date' => $projectAdminDto->project_completion_date,
        'plan_level_id' => $projectAdminDto->plan_level_id,
        'ward_no' => $projectAdminDto->ward_no,
        'allocated_amount' => $projectAdminDto->allocated_amount,
        'project_venue' => $projectAdminDto->project_venue,
        'evaluation_amount' => $projectAdminDto->evaluation_amount,
        'purpose' => $projectAdminDto->purpose,
        'operated_through' => $projectAdminDto->operated_through,
        'progress_spent_amount' => $projectAdminDto->progress_spent_amount,
        'physical_progress_target' => $projectAdminDto->physical_progress_target,
        'physical_progress_completed' => $projectAdminDto->physical_progress_completed,
        'physical_progress_unit' => $projectAdminDto->physical_progress_unit,
        'first_quarterly_amount' => $projectAdminDto->first_quarterly_amount,
        'first_quarterly_goal' => $projectAdminDto->first_quarterly_goal,
        'second_quarterly_amount' => $projectAdminDto->second_quarterly_amount,
        'second_quarterly_goal' => $projectAdminDto->second_quarterly_goal,
        'third_quarterly_amount' => $projectAdminDto->third_quarterly_amount,
        'third_quarterly_goal' => $projectAdminDto->third_quarterly_goal,
        'agencies_grants' => $projectAdminDto->agencies_grants,
        'share_amount' => $projectAdminDto->share_amount,
        'committee_share_amount' => $projectAdminDto->committee_share_amount,
        'labor_amount' => $projectAdminDto->labor_amount,
        'benefited_organization' => $projectAdminDto->benefited_organization,
        'others_benefited' => $projectAdminDto->others_benefited,
        'expense_head_id' => $projectAdminDto->expense_head_id,
        'contingency_amount' => $projectAdminDto->contingency_amount,
        'other_taxes' => $projectAdminDto->other_taxes,
        'is_contracted' => $projectAdminDto->is_contracted,
        'contract_date' => $projectAdminDto->contract_date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Project $project){
    return tap($project)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Project::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


