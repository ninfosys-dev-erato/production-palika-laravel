<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\PlanLevel;

class PlanLevelAdminDto
{
    public function __construct(
        public string $level_name
    ) {}

    public static function fromLiveWireModel(PlanLevel $planLevel): PlanLevelAdminDto
    {
        return new self(
            level_name: $planLevel->level_name
        );
    }
}
