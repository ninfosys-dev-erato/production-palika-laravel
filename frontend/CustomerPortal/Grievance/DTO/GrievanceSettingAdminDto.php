<?php

namespace Src\Grievance\DTO;

use Src\Grievance\Models\GrievanceSetting;

class GrievanceSettingAdminDto
{
    public function __construct(
        public int    $grievance_assigned_to,
        public string $escalation_days,
    )
    {
    }

    public static function fromLiveWireModel(GrievanceSetting $grievanceSetting): GrievanceSettingAdminDto
    {
        return new self(
            grievance_assigned_to: $grievanceSetting->grievance_assigned_to,
            escalation_days: $grievanceSetting->escalation_days,
        );
    }
}
