<?php

namespace Src\Ebps\Traits;

use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\StepRoleService;

trait StepRoleFilterTrait
{
    /**
     * Get accessible steps for a user
     */
    public function getAccessibleSteps($user, $applicationType = null)
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->getAccessibleSteps($user, $applicationType);
    }

    /**
     * Check if user can access a specific step
     */
    public function canUserAccessStep($user, MapStep $step): bool
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->canUserAccessStep($user, $step);
    }

    /**
     * Check if user can submit a specific step
     */
    public function canUserSubmitStep($user, MapStep $step): bool
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->canUserSubmitStep($user, $step);
    }

    /**
     * Check if user can approve a specific step
     */
    public function canUserApproveStep($user, MapStep $step): bool
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->canUserApproveStep($user, $step);
    }

    /**
     * Filter applications based on user's role access to steps
     */
    public function filterApplicationsByUserRole($applications, $user, $applicationType = null)
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
     * Get steps that require submitter roles
     */
    public function getStepsRequiringSubmitterRoles()
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->getStepsRequiringSubmitterRoles();
    }

    /**
     * Get steps that don't require submitter roles
     */
    public function getStepsNotRequiringSubmitterRoles()
    {
        $stepRoleService = new StepRoleService();
        return $stepRoleService->getStepsNotRequiringSubmitterRoles();
    }
} 