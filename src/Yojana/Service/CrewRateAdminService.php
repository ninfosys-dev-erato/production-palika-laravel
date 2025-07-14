<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CrewRateAdminDto;
use Src\Yojana\Models\CrewRate;

class CrewRateAdminService
{
public function store(CrewRateAdminDto $crewRateAdminDto){
    return CrewRate::create([
        'labour_id' => $crewRateAdminDto->labour_id,
        'equipment_id' => $crewRateAdminDto->equipment_id,
        'quantity' => $crewRateAdminDto->quantity,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CrewRate $crewRate, CrewRateAdminDto $crewRateAdminDto){
    return tap($crewRate)->update([
        'labour_id' => $crewRateAdminDto->labour_id,
        'equipment_id' => $crewRateAdminDto->equipment_id,
        'quantity' => $crewRateAdminDto->quantity,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CrewRate $crewRate){
    return tap($crewRate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CrewRate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


