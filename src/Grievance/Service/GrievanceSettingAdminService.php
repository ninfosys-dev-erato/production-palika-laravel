<?php

namespace Src\Grievance\Service;

use App\Facades\FileTrackingFacade;
use Src\Grievance\DTO\GrievanceSettingAdminDto;
use Src\Grievance\Models\GrievanceSetting;

class GrievanceSettingAdminService
{
    public function store(GrievanceSettingAdminDto $grievanceSettingAdminDto)
    {
        return GrievanceSetting::create([
            'grievance_assigned_to' => $grievanceSettingAdminDto->grievance_assigned_to,
            'escalation_days' => $grievanceSettingAdminDto->escalation_days,
        ]);
    }

    public function update(GrievanceSetting $grievanceSetting, GrievanceSettingAdminDto $grievanceSettingAdminDto)
    {
        return tap($grievanceSetting)->update([
            'grievance_assigned_to' => $grievanceSettingAdminDto->grievance_assigned_to,
            'escalation_days' => $grievanceSettingAdminDto->escalation_days,
        ]);
    }
}
