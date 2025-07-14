<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Activity;

class ActivityAdminDto
{
    public function __construct(
        public string $title,
        public string $group_id,
        public string $code,
        public string $ref_code,
        public string $unit_id,
        public string $qty_for,
        public ?bool $will_be_in_use
    ) {}

    public static function fromLiveWireModel(Activity $activity): ActivityAdminDto
    {
        return new self(
            title: $activity->title,
            group_id: $activity->group_id,
            code: $activity->code,
            ref_code: $activity->ref_code,
            unit_id: $activity->unit_id,
            qty_for: $activity->qty_for,
            will_be_in_use: $activity->will_be_in_use ?? false
        );
    }
}
