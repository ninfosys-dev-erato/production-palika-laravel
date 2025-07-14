<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectIncharge;

class ProjectInchargeAdminDto
{
   public function __construct(
        public string $employee_id,
        public string $remarks,
        public string $plan_id,
        public ?bool $is_active
    ){}

public static function fromLiveWireModel(ProjectIncharge $projectIncharge):ProjectInchargeAdminDto{
    return new self(
        employee_id: $projectIncharge->employee_id,
        remarks: $projectIncharge->remarks,
        plan_id: $projectIncharge->plan_id,
        is_active: $projectIncharge->is_active ?? false
    );
}
}
