<?php

namespace Src\Yojana\DTO;

use Illuminate\Support\Facades\Date;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanExtensionRecord;

class PlanExtensionRecordAdminDto
{
   public function __construct(
        public ?string $plan_id,
        public ?string $extension_date,
        public ?string $previous_extension_date,
        public ?string $previous_completion_date,
        public ?string $letter_submission_date,
        public ?string $letter
    ){}

public static function fromLiveWireModel(PlanExtensionRecord $planExtensionRecord):PlanExtensionRecordAdminDto{
    return new self(
        plan_id: $planExtensionRecord->plan_id,
        extension_date: $planExtensionRecord->extension_date,
        previous_extension_date: $planExtensionRecord->previous_extension_date,
        previous_completion_date: $planExtensionRecord->previous_completion_date,
        letter_submission_date: $planExtensionRecord->letter_submission_date,
        letter: $planExtensionRecord->letter
    );
}

public static function fromPlanModel(
    Plan $plan,
    string $extend_to = null,
    string $letter_extension_date = null,
    PlanExtensionRecord $previous_extension_record = null,
) : PlanExtensionRecordAdminDto{
       return new self(
                plan_id:$plan->id,
                extension_date:$extend_to,
                previous_extension_date:$previous_extension_record?$previous_extension_record->extension_date:null,
                previous_completion_date:$plan?->agreement?->plan_completion_date??null,
                letter_submission_date:$letter_extension_date,
                letter:"",
       );
}
}
