<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\SubRegionAdminDto;
use Src\Yojana\Models\SubRegion;

class SubRegionAdminService
{
public function store(SubRegionAdminDto $subRegionAdminDto){
    return SubRegion::create([
        'name' => $subRegionAdminDto->name,
        'code' => $subRegionAdminDto->code,
        'area_id' => $subRegionAdminDto->area_id,
        'in_use' => $subRegionAdminDto->in_use,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(SubRegion $subRegion, SubRegionAdminDto $subRegionAdminDto){
    return tap($subRegion)->update([
        'name' => $subRegionAdminDto->name,
        'code' => $subRegionAdminDto->code,
        'area_id' => $subRegionAdminDto->area_id,
        'in_use' => $subRegionAdminDto->in_use,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(SubRegion $subRegion){
    return tap($subRegion)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    SubRegion::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


