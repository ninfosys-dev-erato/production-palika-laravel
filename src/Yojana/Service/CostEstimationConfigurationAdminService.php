<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CostDetailsAdminDto;
use Src\Yojana\DTO\CostEstimationConfigurationAdminDto;
use Src\Yojana\Models\CostDetails;
use Src\Yojana\Models\CostEstimationConfiguration;

class CostEstimationConfigurationAdminService
{
    public function store(CostEstimationConfigurationAdminDto $costEstimationConfigurationDto){
        return CostEstimationConfiguration::create([
            'cost_estimation_id' => $costEstimationConfigurationDto->cost_estimation_id,
            'configuration' => $costEstimationConfigurationDto->configuration,
            'operation_type' => $costEstimationConfigurationDto->operation_type,
            'rate' => $costEstimationConfigurationDto->rate,
            'amount' => $costEstimationConfigurationDto->amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CostEstimationConfigurationAdminDto $costEstimationConfigurationDto, CostEstimationConfiguration $costEstimationConfiguration){
        return tap($costEstimationConfiguration)->update([
            'cost_estimation_id' => $costEstimationConfigurationDto->cost_estimation_id,
            'configuration' => $costEstimationConfigurationDto->configuration,
            'operation_type' => $costEstimationConfigurationDto->operation_type,
            'rate' => $costEstimationConfigurationDto->rate,
            'amount' => $costEstimationConfigurationDto->amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CostEstimationConfiguration $costEstimationConfiguration){
        return tap($costEstimationConfiguration)->update([
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


