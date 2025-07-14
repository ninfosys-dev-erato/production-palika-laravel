<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CostEstimationLogAdminDto;
use Src\Yojana\Models\CostEstimationLog;

class CostEstimationLogAdminService
{
    public function store(CostEstimationLogAdminDto $costEstimationLogDto){
        return CostEstimationLog::create([
            'cost_estimation_id' => $costEstimationLogDto->cost_estimation_id,
            'status' => $costEstimationLogDto->status,
            'forwarded_to' => $costEstimationLogDto->forwarded_to,
            'remarks' => $costEstimationLogDto->remarks,
            'date' => $costEstimationLogDto->date,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CostEstimationLog $costEstimationLog, CostEstimationLogAdminDto $costEstimationLogDto){
        return tap($costEstimationLog)->update([
            'cost_estimation_id' => $costEstimationLogDto->cost_estimation_id,
            'status' => $costEstimationLogDto->status,
            'forwarded_to' => $costEstimationLogDto->forwarded_to,
            'remarks' => $costEstimationLogDto->remarks,
            'date' => $costEstimationLogDto->date,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CostEstimationLog $costEstimationLog){
        return tap($costEstimationLog)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CostEstimationLog::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


