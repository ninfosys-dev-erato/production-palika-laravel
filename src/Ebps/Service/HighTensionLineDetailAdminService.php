<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\HighTensionLineDetailAdminDto;
use Src\Ebps\Models\HighTensionLineDetail;

class HighTensionLineDetailAdminService
{
public function store(HighTensionLineDetailAdminDto $highTensionLineDetailAdminDto){
    return HighTensionLineDetail::create([
        'map_apply_id' => $highTensionLineDetailAdminDto->map_apply_id,
        'direction' => $highTensionLineDetailAdminDto->direction,
        'distance' => $highTensionLineDetailAdminDto->distance,
        'minimum' => $highTensionLineDetailAdminDto->minimum,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(HighTensionLineDetail $highTensionLineDetail, HighTensionLineDetailAdminDto $highTensionLineDetailAdminDto){
    return tap($highTensionLineDetail)->update([
        'map_apply_id' => $highTensionLineDetailAdminDto->map_apply_id,
        'direction' => $highTensionLineDetailAdminDto->direction,
        'distance' => $highTensionLineDetailAdminDto->distance,
        'minimum' => $highTensionLineDetailAdminDto->minimum,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(HighTensionLineDetail $highTensionLineDetail){
    return tap($highTensionLineDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    HighTensionLineDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function deleteByMapApplyId($mapApplyId)
{
    HighTensionLineDetail::where('map_apply_id', $mapApplyId)->delete();
}
}


