<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\EvaluationCostDetail;

class EvaluationCostDetailAdminDto
{
   public function __construct(
        public string $evaluation_id,
        public string $activity_id,
        public string $unit,
        public string $agreement,
        public string $before_this,
        public string $up_to_date_amount,
        public string $current,
        public string $rate,
        public string $assessment_amount,
        public string $vat_amount
    ){}

public static function fromLiveWireModel(EvaluationCostDetail $evaluationCostDetail):EvaluationCostDetailAdminDto{
    return new self(
        evaluation_id: $evaluationCostDetail->evaluation_id,
        activity_id: $evaluationCostDetail->activity_id,
        unit: $evaluationCostDetail->unit,
        agreement: $evaluationCostDetail->agreement,
        before_this: $evaluationCostDetail->before_this,
        up_to_date_amount: $evaluationCostDetail->up_to_date_amount,
        current: $evaluationCostDetail->current,
        rate: $evaluationCostDetail->rate,
        assessment_amount: $evaluationCostDetail->assessment_amount,
        vat_amount: $evaluationCostDetail->vat_amount
    );
}

    public static function fromArrayData(array $data):EvaluationCostDetailAdminDto{
        return new self(
            evaluation_id: $data['evaluation_id'],
            activity_id: $data['activity_id'],
            unit: $data['unit'],
            agreement: $data['agreement'],
            before_this: $data['before_this'],
            up_to_date_amount: $data['up_to_date_amount'],
            current: $data['current'],
            rate: $data['rate'],
            assessment_amount: $data['assessment_amount'],
            vat_amount: $data['vat_amount']
        );
    }

}
