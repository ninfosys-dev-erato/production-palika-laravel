<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapApplyStepApprover;

class MapApplyStepApproverAdminDto
{
   public function __construct(
        public ?string $map_apply_step_id,
        public ?string $map_pass_group_id,
        public ?string $user_id,
        public ?string $status,
        public ?string $reason,
        public ?string $type
    ){}

public static function fromLiveWireModel(MapApplyStepApprover $mapApplyStepApprover):MapApplyStepApproverAdminDto{
    return new self(
        map_apply_step_id: $mapApplyStepApprover->map_apply_step_id,
        map_pass_group_id: $mapApplyStepApprover->map_pass_group_id,
        user_id: $mapApplyStepApprover->user_id,
        status: $mapApplyStepApprover->status,
        reason: $mapApplyStepApprover->reason,
        type: $mapApplyStepApprover->type
    );
}

public static function fromStepAndUser(
    string $mapApplyStepId,
    string $userId,
    string $status,
    string $reason,
    ?string $mapPassGroupId = null,
    ?string $type = null
): MapApplyStepApproverAdminDto {
    return new self(
        map_apply_step_id: $mapApplyStepId,
        map_pass_group_id: $mapPassGroupId ?? null,
        user_id: $userId,
        status: $status,
        reason: $reason,
        type: $type
    );
}

}
