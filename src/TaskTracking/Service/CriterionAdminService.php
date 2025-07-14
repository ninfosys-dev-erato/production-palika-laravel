<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\CriterionAdminDto;
use Src\TaskTracking\Models\Criterion;

class
CriterionAdminService
{
public function store(CriterionAdminDto $criterionAdminDto){
    return Criterion::create([
        'anusuchi_id' => $criterionAdminDto->anusuchi_id,
        'name' => $criterionAdminDto->name,
        'name_en' => $criterionAdminDto->name_en,
        'max_score' => $criterionAdminDto->max_score,
        'min_score' => $criterionAdminDto->min_score,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Criterion $criterion, CriterionAdminDto $criterionAdminDto){
    return tap($criterion)->update([
        'anusuchi_id' => $criterionAdminDto->anusuchi_id,
        'name' => $criterionAdminDto->name,
        'name_en' => $criterionAdminDto->name_en,
        'max_score' => $criterionAdminDto->max_score,
        'min_score' => $criterionAdminDto->min_score,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Criterion $criterion){
    return tap($criterion)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Criterion::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}