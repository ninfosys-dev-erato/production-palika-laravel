<?php

namespace Src\Yojana\DTO;


use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\CostEstimationDetail;

class CostEstimationDetailsAdminDto
{
    public function __construct(
        public string $cost_estimation_id,
        public string $activity_group_id,
        public string $activity_id,
        public string $unit,
        public string $quantity,
        public string $rate,
        public string $amount,
//        public string $is_vatable,
        public string $vat_amount,

    ){}

    public static function fromLiveWireModel(CostEstimationDetail $costEstimationDetail):CostEstimationDetailsAdminDto{
        return new self(

            cost_estimation_id: $costEstimationDetail->cost_estimation_id,
            activity_group_id: $costEstimationDetail->activity_group_id,
            activity_id: $costEstimationDetail->activity_id,
            unit: $costEstimationDetail->unit,
            quantity: $costEstimationDetail->quantity,
            rate: $costEstimationDetail->rate,
            amount: $costEstimationDetail->amount,
//            is_vatable: $costEstimationDetail->is_vatable,
            vat_amount: $costEstimationDetail->vat_amount ?? 0
        );
    }

    public static function fromArrayData(array $data): CostEstimationDetailsAdminDto
    {
        return new self(
            cost_estimation_id: $data['cost_estimation_id'],
            activity_group_id: $data['activity_group_id'],
            activity_id: $data['activity_id'],
            unit: $data['unit'],
            quantity: $data['quantity'],
            rate: $data['rate'],
            amount: $data['amount'],
//            is_vatable: $data['is_vatable'],
            vat_amount: $data['vat_amount'] ?? 0,
        );
    }

}
