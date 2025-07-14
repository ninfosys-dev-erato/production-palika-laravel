<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementCostDetailsAdminDto;
use Src\Yojana\Models\AgreementCostDetail;

class AgreementCostDetailsAdminService
{
    public function store(AgreementCostDetailsAdminDto $agreementCostDetailDto): AgreementCostDetail
    {
        return AgreementCostDetail::create([
            'agreement_cost_id' => $agreementCostDetailDto->agreement_cost_id,
            'cost_estimation_detail_id' => $agreementCostDetailDto->cost_estimation_detail_id,
            'activity_id' => $agreementCostDetailDto->activity_id,
            'unit' => $agreementCostDetailDto->unit,
            'quantity' => $agreementCostDetailDto->quantity,
            'estimated_rate' => $agreementCostDetailDto->estimated_rate,
            'contractor_rate' => $agreementCostDetailDto->contractor_rate,
            'amount' => $agreementCostDetailDto->amount,
            'vat_amount' => $agreementCostDetailDto->vat_amount,
            'remarks' => $agreementCostDetailDto->remarks,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(AgreementCostDetail $agreementCostDetail, AgreementCostDetailsAdminDto $agreementCostDetailDto): AgreementCostDetail
    {
        return tap($agreementCostDetail)->update([
            'agreement_cost_id' => $agreementCostDetailDto->agreement_cost_id,
            'cost_estimation_detail_id' => $agreementCostDetailDto->cost_estimation_detail_id,
            'activity_id' => $agreementCostDetailDto->activity_id,
            'unit' => $agreementCostDetailDto->unit,
            'quantity' => $agreementCostDetailDto->quantity,
            'estimated_rate' => $agreementCostDetailDto->estimated_rate,
            'contractor_rate' => $agreementCostDetailDto->contractor_rate,
            'amount' => $agreementCostDetailDto->amount,
            'vat_amount' => $agreementCostDetailDto->vat_amount,
            'remarks' => $agreementCostDetailDto->remarks,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(AgreementCostDetail $agreementCostDetail): AgreementCostDetail
    {
        return tap($agreementCostDetail)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            AgreementCostDetail::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


