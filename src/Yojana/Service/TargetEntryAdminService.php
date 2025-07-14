<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\TargetEntryAdminDto;
use Src\Yojana\Models\TargetEntry;

class TargetEntryAdminService
{
public function store(TargetEntryAdminDto $targetEntryAdminDto){
    return TargetEntry::create([
        'progress_indicator_id' => $targetEntryAdminDto->progress_indicator_id,
        'total_physical_progress' => $targetEntryAdminDto->total_physical_progress,
        'total_financial_progress' => $targetEntryAdminDto->total_financial_progress,
        'last_year_physical_progress' => $targetEntryAdminDto->last_year_physical_progress,
        'last_year_financial_progress' => $targetEntryAdminDto->last_year_financial_progress,
        'total_physical_goals' => $targetEntryAdminDto->total_physical_goals,
        'total_financial_goals' => $targetEntryAdminDto->total_financial_goals,
        'first_quarter_physical_progress' => $targetEntryAdminDto->first_quarter_physical_progress,
        'first_quarter_financial_progress' => $targetEntryAdminDto->first_quarter_financial_progress,
        'second_quarter_physical_progress' => $targetEntryAdminDto->second_quarter_physical_progress,
        'second_quarter_financial_progress' => $targetEntryAdminDto->second_quarter_financial_progress,
        'third_quarter_physical_progress' => $targetEntryAdminDto->third_quarter_physical_progress,
        'third_quarter_financial_progress' => $targetEntryAdminDto->third_quarter_financial_progress,
        'plan_id' => $targetEntryAdminDto->plan_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TargetEntry $targetEntry, TargetEntryAdminDto $targetEntryAdminDto){
    return tap($targetEntry)->update([
        'progress_indicator_id' => $targetEntryAdminDto->progress_indicator_id,
        'total_physical_progress' => $targetEntryAdminDto->total_physical_progress,
        'total_financial_progress' => $targetEntryAdminDto->total_financial_progress,
        'last_year_physical_progress' => $targetEntryAdminDto->last_year_physical_progress,
        'last_year_financial_progress' => $targetEntryAdminDto->last_year_financial_progress,
        'total_physical_goals' => $targetEntryAdminDto->total_physical_goals,
        'total_financial_goals' => $targetEntryAdminDto->total_financial_goals,
        'first_quarter_physical_progress' => $targetEntryAdminDto->first_quarter_physical_progress,
        'first_quarter_financial_progress' => $targetEntryAdminDto->first_quarter_financial_progress,
        'second_quarter_physical_progress' => $targetEntryAdminDto->second_quarter_physical_progress,
        'second_quarter_financial_progress' => $targetEntryAdminDto->second_quarter_financial_progress,
        'third_quarter_physical_progress' => $targetEntryAdminDto->third_quarter_physical_progress,
        'third_quarter_financial_progress' => $targetEntryAdminDto->third_quarter_financial_progress,
        'plan_id' => $targetEntryAdminDto->plan_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TargetEntry $targetEntry){
    return tap($targetEntry)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TargetEntry::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


