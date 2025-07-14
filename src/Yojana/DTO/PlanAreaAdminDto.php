<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\PlanArea;

class PlanAreaAdminDto
{
   public function __construct(
        public string $area_name
    ){}

public static function fromLiveWireModel(PlanArea $planArea):PlanAreaAdminDto{
    return new self(
        area_name: $planArea->area_name
    );
}
}
