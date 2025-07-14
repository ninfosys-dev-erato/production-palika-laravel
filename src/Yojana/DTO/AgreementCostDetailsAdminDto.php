<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementCost;
use Src\Yojana\Models\AgreementCostDetail;

class AgreementCostDetailsAdminDto
{
    public function __construct(
        public string $agreement_cost_id,
        public string $cost_estimation_detail_id,
        public string $activity_id,
        public string $unit,
        public string $quantity,
        public string $estimated_rate,
        public string $contractor_rate,
        public string $amount,
        public string $vat_amount,
        public string $remarks
    ){}

    public static function fromLiveWireModel(AgreementCostDetail $agreementCostDetail): AgreementCostDetailsAdminDto
    {
        return new self(
            agreement_cost_id : $agreementCostDetail->agreement_cost_id,
            cost_estimation_detail_id : $agreementCostDetail->cost_estimation_detail_id,
            activity_id : $agreementCostDetail->activity_id,
            unit : $agreementCostDetail->unit,
            quantity : $agreementCostDetail->quantity,
            estimated_rate : $agreementCostDetail->estimated_rate,
            contractor_rate : $agreementCostDetail->contractor_rate,
            amount : $agreementCostDetail->amount,
            vat_amount : $agreementCostDetail->vat_amount,
            remarks: $agreementCostDetail->remarks ?? ''
        );
    }

    public static function fromArrayData(array $data) : self
    {
        return new self(
            agreement_cost_id: $data['agreement_cost_id'],
            cost_estimation_detail_id: $data['cost_estimation_detail_id'],
            activity_id: $data['activity_id'],
            unit: $data['unit'],
            quantity: $data['quantity'],
            estimated_rate: $data['estimated_rate'],
            contractor_rate: $data['contractor_rate'],
            amount: $data['amount'],
            vat_amount: $data['vat_amount'],
            remarks: $data['remarks'] ?? ''
        );
    }
}
