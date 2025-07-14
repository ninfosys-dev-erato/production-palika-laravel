<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectAllocatedAmount;

class ProjectAllocatedAmountAdminDto
{
   public function __construct(
        public string $project_id,
        public string $budget_head_id,
        public string $amount
    ){}

public static function fromLiveWireModel(ProjectAllocatedAmount $projectAllocatedAmount):ProjectAllocatedAmountAdminDto{
    return new self(
        project_id: $projectAllocatedAmount->project_id,
        budget_head_id: $projectAllocatedAmount->budget_head_id,
        amount: $projectAllocatedAmount->amount
    );
}
}
