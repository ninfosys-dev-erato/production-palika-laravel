<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\CantileverDetailAdminDto;
use Src\Ebps\Models\CantileverDetail;

class CantileverDetailAdminService
{
public function store(CantileverDetailAdminDto $cantileverDetailAdminDto){
    return CantileverDetail::create([
        'map_apply_id' => $cantileverDetailAdminDto->map_apply_id,
        'direction' => $cantileverDetailAdminDto->direction,
        'distance' => $cantileverDetailAdminDto->distance,
        'minimum' => $cantileverDetailAdminDto->minimum,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(CantileverDetail $cantileverDetail, CantileverDetailAdminDto $cantileverDetailAdminDto){
    return tap($cantileverDetail)->update([
        'map_apply_id' => $cantileverDetailAdminDto->map_apply_id,
        'direction' => $cantileverDetailAdminDto->direction,
        'distance' => $cantileverDetailAdminDto->distance,
        'minimum' => $cantileverDetailAdminDto->minimum,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CantileverDetail $cantileverDetail){
    return tap($cantileverDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CantileverDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function deleteByMapApplyId($mapApplyId)
{
    CantileverDetail::where('map_apply_id', $mapApplyId)->delete();
}
}


