<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CollateralAdminDto;
use Src\Yojana\Models\Collateral;

class CollateralAdminService
{
    public function store(CollateralAdminDto $collateralAdminDto): Collateral
    {
        return Collateral::create([
            'plan_id' => $collateralAdminDto->plan_id,
            'party_type' => $collateralAdminDto->party_type,
            'party_id' => $collateralAdminDto->party_id,
            'deposit_type' => $collateralAdminDto->deposit_type,
            'deposit_number' => $collateralAdminDto->deposit_number,
            'contract_number' => $collateralAdminDto->contract_number,
            'bank' => $collateralAdminDto->bank,
            'issue_date' => $collateralAdminDto->issue_date,
            'validity_period' => $collateralAdminDto->validity_period,
            'amount' => $collateralAdminDto->amount,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(Collateral $collateral, CollateralAdminDto $collateralAdminDto): Collateral
    {
        return tap($collateral)->update([
            'plan_id' => $collateralAdminDto->plan_id,
            'party_type' => $collateralAdminDto->party_type,
            'party_id' => $collateralAdminDto->party_id,
            'deposit_type' => $collateralAdminDto->deposit_type,
            'deposit_number' => $collateralAdminDto->deposit_number,
            'contract_number' => $collateralAdminDto->contract_number,
            'bank' => $collateralAdminDto->bank,
            'issue_date' => $collateralAdminDto->issue_date,
            'validity_period' => $collateralAdminDto->validity_period,
            'amount' => $collateralAdminDto->amount,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(Collateral $collateral): Collateral
    {
        return tap($collateral)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            Collateral::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


