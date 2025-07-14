<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\CostEstimationLog;

class CostEstimationLogAdminDto
{
    public function __construct(
        public string $cost_estimation_id,
        public string $status="",
        public string $forwarded_to="",
        public string $remarks="",
        public string $date="",
    ){}

    public static function fromLiveWireModel(CostEstimationLog $costEstimationLog): CostEstimationLogAdminDto
    {
        return new self(
            cost_estimation_id: $costEstimationLog->cost_estimation_id,
            status: $costEstimationLog->status??"",
            forwarded_to: $costEstimationLog->forwarded_to??"",
            remarks: $costEstimationLog->remarks??"",
            date: $costEstimationLog->date??"",
        );
    }
}
