<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\TechnicalCostEstimate;

class TechnicalCostEstimateAdminDto
{
   public function __construct(
        public string $project_id,
        public string $detail,
        public string $quantity,
        public string $unit_id,
        public string $rate
    ){}

public static function fromLiveWireModel(TechnicalCostEstimate $technicalCostEstimate):TechnicalCostEstimateAdminDto{
    return new self(
        project_id: $technicalCostEstimate->project_id,
        detail: $technicalCostEstimate->detail,
        quantity: $technicalCostEstimate->quantity,
        unit_id: $technicalCostEstimate->unit_id,
        rate: $technicalCostEstimate->rate
    );
}
}
