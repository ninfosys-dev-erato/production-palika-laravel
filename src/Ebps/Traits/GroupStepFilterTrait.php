<?php

namespace Src\Ebps\Traits;

use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\GroupStepService;

trait GroupStepFilterTrait
{
    /**
     * Get accessible steps for a user
     */
    public function getAccessibleSteps($user, $applicationType = null)
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->getAccessibleSteps($user, $applicationType);
    }

    /**
     * Check if user can access a specific step
     */
    public function canUserAccessStep($user, MapStep $step): bool
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->canUserAccessStep($user, $step);
    }

    /**
     * Check if user can submit a specific step
     */
    public function canUserSubmitStep($user, MapStep $step): bool
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->canUserSubmitStep($user, $step);
    }

    /**
     * Check if user can approve a specific step
     */
    public function canUserApproveStep($user, MapStep $step): bool
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->canUserApproveStep($user, $step);
    }

    /**
     * Filter applications based on user's group access to steps
     */
    public function filterApplicationsByUserGroup($applications, $user, $applicationType = null)
    {
        $accessibleSteps = $this->getAccessibleSteps($user, $applicationType);
        $accessibleStepIds = $accessibleSteps->pluck('id')->toArray();

        return $applications->filter(function ($application) use ($accessibleStepIds, $user) {
            // Get the current step for this application
            $currentStep = $this->getCurrentStepForApplication($application);
            
            if (!$currentStep) {
                return false;
            }

            // Check if user can access this step
            return in_array($currentStep->id, $accessibleStepIds);
        });
    }

    /**
     * Get the current step for an application
     * This method should be implemented based on your application logic
     */
    protected function getCurrentStepForApplication($application)
    {
        // This is a placeholder - implement based on your application structure
        // You might need to check the application's current status, step position, etc.
        
        // Example implementation:
        // return MapStep::where('application_type', $application->application_type)
        //     ->where('form_position', $application->current_step_position)
        //     ->first();
        
        return null; // Implement based on your needs
    }

    /**
     * Get steps that require submitter groups
     */
    public function getStepsRequiringSubmitterGroups()
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->getStepsRequiringSubmitterGroups();
    }

    /**
     * Get steps that don't require submitter groups
     */
    public function getStepsNotRequiringSubmitterGroups()
    {
        $groupStepService = new GroupStepService();
        return $groupStepService->getStepsNotRequiringSubmitterGroups();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function filterApplicationsByUserRole($applications, $user, $applicationType = null)
    {
        return $this->filterApplicationsByUserGroup($applications, $user, $applicationType);
    }

    /**
     * Legacy method for backward compatibility
     */
    public function getStepsRequiringSubmitterRoles()
    {
        return $this->getStepsRequiringSubmitterGroups();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function getStepsNotRequiringSubmitterRoles()
    {
        return $this->getStepsNotRequiringSubmitterGroups();
    }
} 