<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\TargetCompletion;
use Src\Yojana\Models\TargetEntry;

class TargetCompletionAdminDto
{
    public function __construct(
        public string $plan_id,
        public string $target_entry_id,
        public string $completed_physical_goal,
        public string $completed_financial_goal
    ){}

    public static function fromLiveWireModel(TargetCompletion $targetCompletion):TargetCompletionAdminDto{
        return new self(
            plan_id: $targetCompletion->plan_id,
            target_entry_id: $targetCompletion->target_entry_id,
            completed_physical_goal: $targetCompletion->completed_physical_goal,
            completed_financial_goal: $targetCompletion->completed_financial_goal
        );
    }
}
