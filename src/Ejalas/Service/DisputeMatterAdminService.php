<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\DisputeMatterAdminDto;
use Src\Ejalas\Models\DisputeMatter;

class DisputeMatterAdminService
{
public function store(DisputeMatterAdminDto $disputeMatterAdminDto){
    return DisputeMatter::create([
        'title' => $disputeMatterAdminDto->title,
        'dispute_area_id' => $disputeMatterAdminDto->dispute_area_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(DisputeMatter $disputeMatter, DisputeMatterAdminDto $disputeMatterAdminDto){
    return tap($disputeMatter)->update([
        'title' => $disputeMatterAdminDto->title,
        'dispute_area_id' => $disputeMatterAdminDto->dispute_area_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(DisputeMatter $disputeMatter){
    return tap($disputeMatter)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    DisputeMatter::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


