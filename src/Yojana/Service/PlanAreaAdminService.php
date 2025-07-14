<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PlanAreaAdminDto;
use Src\Yojana\Models\PlanArea;

class PlanAreaAdminService
{
public function store(PlanAreaAdminDto $planAreaAdminDto){
    return PlanArea::create([
        'area_name' => $planAreaAdminDto->area_name,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(PlanArea $planArea, PlanAreaAdminDto $planAreaAdminDto){
    return tap($planArea)->update([
        'area_name' => $planAreaAdminDto->area_name,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(PlanArea $planArea){
    return tap($planArea)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    PlanArea::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


