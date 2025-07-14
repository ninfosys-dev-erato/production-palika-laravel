<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\StoreyDetailAdminDto;
use Src\Ebps\Models\StoreyDetail;

class StoreyDetailAdminService
{
public function store(StoreyDetailAdminDto $storeyDetailAdminDto){
    return StoreyDetail::create([
        'map_apply_id' => $storeyDetailAdminDto->map_apply_id,
        'storey_id' => $storeyDetailAdminDto->storey_id,
        'purposed_area' => $storeyDetailAdminDto->purposed_area,
        'former_area' => $storeyDetailAdminDto->former_area,
        'height' => $storeyDetailAdminDto->height,
        'remarks' => $storeyDetailAdminDto->remarks,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(StoreyDetail $storeyDetail, StoreyDetailAdminDto $storeyDetailAdminDto){
    return tap($storeyDetail)->update([
        'map_apply_id' => $storeyDetailAdminDto->map_apply_id,
        'storey_id' => $storeyDetailAdminDto->storey_id,
        'purposed_area' => $storeyDetailAdminDto->purposed_area,
        'former_area' => $storeyDetailAdminDto->former_area,
        'height' => $storeyDetailAdminDto->height,
        'remarks' => $storeyDetailAdminDto->remarks,
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
}
public function delete(StoreyDetail $storeyDetail){
    return tap($storeyDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    StoreyDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function deleteByMapApplyId($mapApplyId)
{
    StoreyDetail::where('map_apply_id', $mapApplyId)->delete();
}
}


