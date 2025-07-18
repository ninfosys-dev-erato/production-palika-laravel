<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PlanAdminDto;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\Plan;

class PlanAdminService
{
public function store(PlanAdminDto $planAdminDto){
    return Plan::create([
        'project_name' => $planAdminDto->project_name,
        'implementation_method_id' => $planAdminDto->implementation_method_id,
        'location' => $planAdminDto->location,
        'ward_id' => $planAdminDto->ward_id,
        'start_fiscal_year_id' => $planAdminDto->start_fiscal_year_id,
        'operate_fiscal_year_id' => $planAdminDto->operate_fiscal_year_id,
        'area_id' => $planAdminDto->area_id,
        'sub_region_id' => $planAdminDto->sub_region_id,
        'targeted_id' => $planAdminDto->targeted_id,
        'implementation_level_id' => $planAdminDto->implementation_level_id,
        'plan_type' => $planAdminDto->plan_type,
        'nature' => $planAdminDto->nature,
        'project_group_id' => $planAdminDto->project_group_id,
        'purpose' => $planAdminDto->purpose,
        'red_book_detail' => $planAdminDto->red_book_detail,
        'allocated_budget' => $planAdminDto->allocated_budget,
        'remaining_budget' => $planAdminDto->remaining_budget,
        'category' => $planAdminDto->category,
        'department' => $planAdminDto->department,
        'status' => PlanStatus::PlanEntry,

//        'source_id' => $planAdminDto->source_id,
//        'program' => $planAdminDto->program,
//        'budget_head_id' => $planAdminDto->budget_head_id,
//        'expense_head_id' => $planAdminDto->expense_head_id,
//        'fiscal_year_id' => $planAdminDto->fiscal_year_id,
//        'amount' => $planAdminDto->amount,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Plan $plan, PlanAdminDto $planAdminDto){
    return tap($plan)->update([
        'project_name' => $planAdminDto->project_name,
        'implementation_method_id' => $planAdminDto->implementation_method_id,
        'location' => $planAdminDto->location,
        'ward_id' => $planAdminDto->ward_id,
        'start_fiscal_year_id' => $planAdminDto->start_fiscal_year_id,
        'operate_fiscal_year_id' => $planAdminDto->operate_fiscal_year_id,
        'area_id' => $planAdminDto->area_id,
        'sub_region_id' => $planAdminDto->sub_region_id,
        'targeted_id' => $planAdminDto->targeted_id,
        'implementation_level_id' => $planAdminDto->implementation_level_id,
        'plan_type' => $planAdminDto->plan_type,
        'nature' => $planAdminDto->nature,
        'project_group_id' => $planAdminDto->project_group_id,
        'purpose' => $planAdminDto->purpose,
        'red_book_detail' => $planAdminDto->red_book_detail,
        'allocated_budget' => $planAdminDto->allocated_budget,
        'remaining_budget' => $planAdminDto->remaining_budget,
        'department' => $planAdminDto->department,

//        'source_id' => $planAdminDto->source_id,
//        'program' => $planAdminDto->program,
//        'budget_head_id' => $planAdminDto->budget_head_id,
//        'expense_head_id' => $planAdminDto->expense_head_id,
//        'fiscal_year_id' => $planAdminDto->fiscal_year_id,
//        'amount' => $planAdminDto->amount,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Plan $plan){
    return tap($plan)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Plan::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


