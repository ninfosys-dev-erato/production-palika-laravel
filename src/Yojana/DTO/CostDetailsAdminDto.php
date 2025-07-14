<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Activity;
use Src\Yojana\Models\CostDetails;

class CostDetailsAdminDto
{
    public function __construct(
        public string $cost_estimation_id,
        public string $cost_source,
        public string $cost_amount,
    ) {}

    public static function fromLiveWireModel(CostDetails $costDetails): CostDetailsAdminDto
    {
        return new self(
            cost_estimation_id: $costDetails->cost_estimation_id,
            cost_source: $costDetails->cost_source,
            cost_amount: $costDetails->cost_amount,

        );
    }

    public static function fromArrayData(array $data): self
    {
        return new self(
            cost_estimation_id: $data['cost_estimation_id'],
            cost_source: $data['cost_source'],
            cost_amount: $data['cost_amount'],
        );
    }


}
