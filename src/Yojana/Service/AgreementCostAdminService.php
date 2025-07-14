<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementCostAdminDto;
use Src\Yojana\Models\AgreementCost;

class AgreementCostAdminService
{
    public function store(AgreementCostAdminDto $agreementCostAdminDto): AgreementCost
    {
        return AgreementCost::create([
            'agreement_id' => $agreementCostAdminDto->agreement_id,
            'total_amount' => $agreementCostAdminDto->total_amount,
            'total_vat_amount' => $agreementCostAdminDto->total_vat_amount,
            'total_with_vat' => $agreementCostAdminDto->total_with_vat,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(AgreementCost $agreementCost, AgreementCostAdminDto $agreementCostAdminDto): AgreementCost
    {
        return tap($agreementCost)->update([
            'agreement_id' => $agreementCostAdminDto->agreement_id,
            'total_amount' => $agreementCostAdminDto->total_amount,
            'total_vat_amount' => $agreementCostAdminDto->total_vat_amount,
            'total_with_vat' => $agreementCostAdminDto->total_with_vat,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(AgreementCost $agreementCost): AgreementCost
    {
        return tap($agreementCost)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            AgreementCost::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


