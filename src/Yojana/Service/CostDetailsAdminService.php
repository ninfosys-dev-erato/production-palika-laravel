<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CostDetailsAdminDto;
use Src\Yojana\Models\CostDetails;

class CostDetailsAdminService
{
    public function store(CostDetailsAdminDto $costDetailsDto){
        return CostDetails::create([
            'cost_estimation_id' => $costDetailsDto->cost_estimation_id,
            'cost_source' => $costDetailsDto->cost_source,
            'cost_amount' => $costDetailsDto->cost_amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CostDetails $costDetails, CostDetailsAdminDto $costDetailsDto){
        return tap($costDetails)->update([
            'cost_estimation_id' => $costDetailsDto->cost_estimation_id,
            'cost_source' => $costDetailsDto->cost_source,
            'cost_amount' => $costDetailsDto->cost_amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CostDetails $costDetails){
        return tap($costDetails)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CostDetails::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


