<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\TechnicalCostEstimateAdminDto;
use Src\Yojana\Models\TechnicalCostEstimate;

class TechnicalCostEstimateAdminService
{
public function store(TechnicalCostEstimateAdminDto $technicalCostEstimateAdminDto){
    return TechnicalCostEstimate::create([
        'project_id' => $technicalCostEstimateAdminDto->project_id,
        'detail' => $technicalCostEstimateAdminDto->detail,
        'quantity' => $technicalCostEstimateAdminDto->quantity,
        'unit_id' => $technicalCostEstimateAdminDto->unit_id,
        'rate' => $technicalCostEstimateAdminDto->rate,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TechnicalCostEstimate $technicalCostEstimate, TechnicalCostEstimateAdminDto $technicalCostEstimateAdminDto){
    return tap($technicalCostEstimate)->update([
        'project_id' => $technicalCostEstimateAdminDto->project_id,
        'detail' => $technicalCostEstimateAdminDto->detail,
        'quantity' => $technicalCostEstimateAdminDto->quantity,
        'unit_id' => $technicalCostEstimateAdminDto->unit_id,
        'rate' => $technicalCostEstimateAdminDto->rate,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TechnicalCostEstimate $technicalCostEstimate){
    return tap($technicalCostEstimate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TechnicalCostEstimate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


