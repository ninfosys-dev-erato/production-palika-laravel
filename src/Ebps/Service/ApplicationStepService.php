<?php

namespace Src\Ebps\Service;

use Src\Ebps\Enums\FormPositionEnum;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;

class ApplicationStepService
{
    /**
     * Check if the first step (before_filling_application) has been approved for a map apply
     */
    public function isFirstStepApprovedForMapApply(int $mapApplyId): bool
    {
        return $this->isFirstStepApproved($mapApplyId, 'map_applies');
    }

    /**
     * Check if the first step (before_filling_application) has been approved for building registration
     */
    public function isFirstStepApprovedForBuildingRegistration(int $mapApplyId): bool
    {
        return $this->isFirstStepApproved($mapApplyId, 'building_documentation');
    }

    /**
     * Generic method to check if the first step has been approved for any application type
     */
    public function isFirstStepApproved(int $mapApplyId, string $applicationType = 'map_applies'): bool
    {
        // Get the first step (before_filling_application) for the specified application type
        $firstStep = MapStep::whereNull('deleted_by')
            ->where('form_position', FormPositionEnum::BEFORE_FILLING_APPLICATION)
            ->where('application_type', $applicationType)
            ->orderBy('id')
            ->first();
            
        if (!$firstStep) {
            return false;
        }
        
        // Check if this step has been applied and approved
        $mapApplyStep = MapApplyStep::where('map_apply_id', $mapApplyId)
            ->where('map_step_id', $firstStep->id)
            ->first();
            
        return $mapApplyStep && $mapApplyStep->status === 'accepted';
    }

    /**
     * Check if any step has been approved for a map apply
     */
    public function hasAnyStepApproved(int $mapApplyId): bool
    {
        return MapApplyStep::where('map_apply_id', $mapApplyId)
            ->where('status', 'accepted')
            ->exists();
    }

    /**
     * Get the current step status for a map apply
     */
    public function getCurrentStepStatus(int $mapApplyId): ?string
    {
        $mapApplyStep = MapApplyStep::where('map_apply_id', $mapApplyId)
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $mapApplyStep ? $mapApplyStep->status : null;
    }

    /**
     * Check if application can be edited based on step approval status
     */
    public function canEditApplication(int $mapApplyId, string $applicationType = 'map_applies'): bool
    {
        return !$this->isFirstStepApproved($mapApplyId, $applicationType);
    }

    /**
     * Check if application can be deleted based on step approval status
     */
    public function canDeleteApplication(int $mapApplyId, string $applicationType = 'map_applies'): bool
    {
        return !$this->isFirstStepApproved($mapApplyId, $applicationType);
    }
} 