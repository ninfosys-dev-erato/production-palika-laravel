<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;

class MapApplyStepAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $form_id,
        public ?string $map_step_id,
        public ?string $reviewed_by,
        public ?string $template,
        public ?MapApplyStatusEnum $status,
        public ?string $reason,
        public ?string $sent_to_approver_at
    ){}

public static function fromLiveWireModel($formId, $letter, MapApply $mapApply, MapStep $mapStep ):MapApplyStepAdminDto{

    return new self(
        map_apply_id: $mapApply->id,
        form_id: $formId,
        map_step_id: $mapStep->id,
        reviewed_by: $mapApplyStep->reviewed_by ?? null,
        template: $letter ?? null,
        status: $mapApplyStep->status ?? MapApplyStatusEnum::PENDING,
        reason: $mapApplyStep->reason ?? null,
        sent_to_approver_at: $mapApplyStep->sent_to_approver_at ?? null
    );
}
}
