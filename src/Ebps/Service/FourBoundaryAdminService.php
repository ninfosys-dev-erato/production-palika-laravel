<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\Models\FourBoundary;

class FourBoundaryAdminService
{
public function store($fourBoundaryAdminDto){
    return FourBoundary::create([
        'land_detail_id' => $fourBoundaryAdminDto->land_detail_id,
        'title' => $fourBoundaryAdminDto->title,
        'direction' => $fourBoundaryAdminDto->direction,
        'distance' => $fourBoundaryAdminDto->distance,
        'lot_no' => $fourBoundaryAdminDto->lot_no,
        'created_at' => date('Y-m-d H:i:s'),
        // 'created_by' => Auth::user()->id,
    ]);
}
public function update(FourBoundary $fourBoundary, FourBoundaryAdminDto $fourBoundaryAdminDto){
    return tap($fourBoundary)->update([
        'land_detail_id' => $fourBoundaryAdminDto->land_detail_id,
        'title' => $fourBoundaryAdminDto->title,
        'direction' => $fourBoundaryAdminDto->direction,
        'distance' => $fourBoundaryAdminDto->distance,
        'lot_no' => $fourBoundaryAdminDto->lot_no,
        'updated_at' => date('Y-m-d H:i:s'),
        // 'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FourBoundary $fourBoundary){
    return tap($fourBoundary)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FourBoundary::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


