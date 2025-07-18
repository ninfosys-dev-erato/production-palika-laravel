<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ImplementationContractDetailsDto;
use Src\Yojana\Models\ImplementationContractDetails;

class ImplementationContractDetailService
{
    public function store(ImplementationContractDetailsDto $implementationContractDetailDto){
        return ImplementationContractDetails::create([
            'implementation_agency_id' => $implementationContractDetailDto->implementation_agency_id,
            'contract_number' => $implementationContractDetailDto->contract_number,
            'notice_date' => $implementationContractDetailDto->notice_date,
            'bid_acceptance_date' => $implementationContractDetailDto->bid_acceptance_date,
            'bid_amount' => $implementationContractDetailDto->bid_amount,
            'deposit_amount' => $implementationContractDetailDto->deposit_amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(ImplementationContractDetails $implementationContractDetails, ImplementationContractDetailsDto $implementationContractDetailDto){
        return tap($implementationContractDetails)->update([
            'implementation_agency_id' => $implementationContractDetailDto->implementation_agency_id,
            'contract_number' => $implementationContractDetailDto->contract_number,
            'notice_date' => $implementationContractDetailDto->notice_date,
            'bid_acceptance_date' => $implementationContractDetailDto->bid_acceptance_date,
            'bid_amount' => $implementationContractDetailDto->bid_amount,
            'deposit_amount' => $implementationContractDetailDto->deposit_amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(ImplementationContractDetails $implementationContractDetails){
        return tap($implementationContractDetails)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        ImplementationContractDetails::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


