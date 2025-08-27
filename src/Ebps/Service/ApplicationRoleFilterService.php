<?php

namespace Src\Ebps\Service;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Models\MapApplyStep;

class ApplicationRoleFilterService
{
    /**
     * Filter applications query based on current user's groups and step access
     */
    public function filterApplicationsByUserGroups(Builder $query, $applicationType = null): Builder
    {
        // Role filtering is always enabled - no setting check needed
        $user = Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // Return no results if no user
        }

        // Superadmin should see everything
        if (isSuperAdmin()) {
            return $query;
        }

        // Get steps that user can access (either submit or approve) based on groups
        $accessibleSteps = MapStep::whereHas('mapPassGroupMapSteps', function ($stepGroupQuery) use ($user) {
            $stepGroupQuery->whereHas('mapPassGroup.users', function ($userQuery) use ($user) {
                $userQuery->where('user_id', $user->id);
            });
        });

        if ($applicationType) {
            $accessibleSteps->where('application_type', $applicationType);
        }

        $accessibleStepIds = $accessibleSteps->pluck('id')->toArray();

        if (empty($accessibleStepIds)) {
            return $query->whereRaw('1 = 0'); // Return no results if user can't access any steps
        }

        // Simplify the filtering - just check if user has access to ANY step for applications with the right type
        // Let the table and UI logic handle the detailed step filtering
        $return = $query->whereExists(function ($subQuery) use ($accessibleStepIds) {
            $subQuery->selectRaw('1')
                ->from('ebps_map_steps')
                ->whereIn('id', $accessibleStepIds)
                ->whereColumn('application_type', 'ebps_map_applies.application_type')
                ->limit(1);
        });

        return $return;
    }

    /**
     * Get the current step for an application
     */
    public function getCurrentStep(MapApply $application): ?MapStep
    {
        // Get all defined steps for this application type, ordered by position
        $allSteps = MapStep::where('application_type', $application->application_type)
            ->orderBy('position')
            ->get();

        
        if ($allSteps->isEmpty()) {
            return null;
        }

        // Get all step records for this application
        $applicationSteps = $application->mapApplySteps()
            ->with('mapStep')
            ->get()
            ->keyBy('map_step_id');
        // Go through steps in order to find the current one
        foreach ($allSteps as $step) {
            $stepRecord = $applicationSteps->get($step->id);
            
            if (!$stepRecord) {
                // This step hasn't been started yet - this is the current step
                return $step;
            }
            
            if ($stepRecord->status !== 'accepted') {
                // This step exists but is not accepted - this is the current step
                return $step;
            }
            
            // This step is accepted, continue to next step
        }
        
        // All steps are completed
        return null;
    }

    /**
     * Check if user can access a specific application
     */
    public function canUserAccessApplication(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always access
        if (isSuperAdmin()) {
            return true;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        return $currentStep->canUserAccess($user);
    }

    /**
     * Check if user can access a specific step (for step action buttons)
     */
    public function canUserAccessStep(MapStep $step, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always access
        if (isSuperAdmin()) {
            return true;
        }

        // Check if user has any group that can access this step (submit or approve)
        return $step->canUserAccess($user);
    }

    /**
     * Check if user can perform action on a specific step (for apply buttons)
     */
    public function canUserPerformStepAction(MapStep $step, MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always perform actions
        if (isSuperAdmin()) {
            return true;
        }

        // Check if user can submit or approve this specific step
        return $step->canUserSubmit($user) || $step->canUserApprove($user);
    }

    /**
     * Enhanced method to filter applications based on current step and user groups
     */
    public function filterApplicationsByCurrentStepAccess(Builder $query, $applicationType = null): Builder
    {
        // Role filtering is always enabled - no setting check needed
        $user = Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // Return no results if no user
        }

        // Superadmin should see everything
        if (isSuperAdmin()) {
            return $query;
        }

        // Get all applications and filter them based on current step access
        $allApplications = $query->get();
        $accessibleApplicationIds = [];

        foreach ($allApplications as $application) {
            $currentStep = $this->getCurrentStep($application);
            
            // If no current step (all steps completed), skip this application
            if (!$currentStep) {
                continue;
            }

            // Check if user has access to the current step
            $canSubmit = $currentStep->canUserSubmit($user);
            $canApprove = $currentStep->canUserApprove($user);
            
            if ($canSubmit || $canApprove) {
                $accessibleApplicationIds[] = $application->id;
            }
        }

        // Return query filtered to only accessible applications
        if (empty($accessibleApplicationIds)) {
            return $query->whereRaw('1 = 0'); // No accessible applications
        }

        return $query->whereIn('ebps_map_applies.id', $accessibleApplicationIds);
    }

    /**
     * Check if user can submit for a specific application
     */
    public function canUserSubmitApplication(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        // Only allow submission if the current step is not yet completed
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $currentStep->id)
            ->first();
            
        $status = $stepRecord ? $stepRecord->status : null;
        
        // Can submit if step doesn't exist or is pending/rejected
        $canSubmitBasedOnStatus = !$stepRecord || in_array($status, ['pending', 'rejected', null]);

        return $canSubmitBasedOnStatus && $currentStep->canUserSubmit($user);
    }

    /**
     * Check if user can approve a specific application
     */
    public function canUserApproveApplication(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        // Only allow approval if the current step is submitted/pending
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $currentStep->id)
            ->first();
            
        $status = $stepRecord ? $stepRecord->status : null;
        
        // Can approve if step is submitted or pending
        $canApproveBasedOnStatus = in_array($status, ['submitted', 'pending']);

        return $canApproveBasedOnStatus && $currentStep->canUserApprove($user);
    }

    /**
     * Get action buttons for an application based on user groups
     */
    public function getActionButtonsForApplication(MapApply $application, $user = null): array
    {
        $user = $user ?: Auth::user();
        $buttons = [];

        if (!$user) {
            return $buttons;
        }

        // Always show view button if user can access the application
        if ($this->canUserAccessApplication($application, $user)) {
            $buttons['view'] = true;
        }

        // Show edit button if user can submit
        if ($this->canUserSubmitApplication($application, $user)) {
            $buttons['edit'] = true;
        }

        // Show move forward button if user can approve
        if ($this->canUserApproveApplication($application, $user)) {
            $buttons['move_forward'] = true;
        }

        return $buttons;
    }

    /**
     * Get the next step that needs action for an application
     */
    public function getNextActionableStep(MapApply $application): ?MapStep
    {
        // Find steps that are pending or not yet created
        $allSteps = MapStep::where('application_type', $application->application_type)
            ->orderBy('position')
            ->get();

        foreach ($allSteps as $step) {
            $appliedStep = $application->mapApplySteps()
                ->where('map_step_id', $step->id)
                ->first();

            // If step doesn't exist or is not accepted, this is the next actionable step
            if (!$appliedStep || $appliedStep->status !== 'accepted') {
                return $step;
            }
        }

        return null; // All steps completed
    }

    /**
     * Get status information for display
     */
    public function getStepStatusInfo(MapApply $application, MapStep $step): array
    {
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $step->id)
            ->first();

        if (!$stepRecord) {
            return [
                'status' => 'not_started',
                'label' => __('ebps::ebps.not_started'),
                'badge_class' => 'bg-secondary'
            ];
        }

        $statusLabels = [
            'pending' => __('ebps::ebps.pending'),
            'submitted' => __('ebps::ebps.submitted'),
            'accepted' => __('ebps::ebps.accepted'),
            'rejected' => __('ebps::ebps.rejected'),
        ];

        $badgeClasses = [
            'pending' => 'bg-warning',
            'submitted' => 'bg-info',
            'accepted' => 'bg-success',
            'rejected' => 'bg-danger',
        ];

        return [
            'status' => $stepRecord->status,
            'label' => $statusLabels[$stepRecord->status] ?? ucfirst($stepRecord->status),
            'badge_class' => $badgeClasses[$stepRecord->status] ?? 'bg-secondary'
        ];
    }

    /**
     * Debug method to understand filtering results
     */
    public function debugApplicationAccess(MapApply $application, $user = null): array
    {
        $user = $user ?: Auth::user();
        $debug = [];
        
        $debug['application_id'] = $application->id;
        $debug['submission_id'] = $application->submission_id;
        $debug['application_type'] = $application->application_type;
        
        if (!$user) {
            $debug['error'] = 'No authenticated user';
            return $debug;
        }
        
        $userGroups = $user->mapPassGroupUsers()->with('mapPassGroup')->get();
        $debug['user_groups'] = $userGroups->map(function($userGroup) {
            return [
                'group_id' => $userGroup->mapPassGroup->id,
                'group_title' => $userGroup->mapPassGroup->title,
            ];
        })->toArray();
        
        if ($userGroups->isEmpty()) {
            $debug['error'] = 'User has no groups assigned';
            return $debug;
        }
        
        // Get current step
        $currentStep = $this->getCurrentStep($application);
        $debug['current_step'] = $currentStep ? [
            'id' => $currentStep->id,
            'title' => $currentStep->title,
            'position' => $currentStep->position,
        ] : null;
        
        if (!$currentStep) {
            $debug['error'] = 'No current step found';
            return $debug;
        }
        
        // Check step groups
        $stepGroups = $currentStep->mapPassGroupMapSteps()->with('mapPassGroup')->get();
        $debug['step_groups'] = $stepGroups->map(function($stepGroup) {
            return [
                'group_id' => $stepGroup->mapPassGroup->id,
                'group_title' => $stepGroup->mapPassGroup->title,
                'type' => $stepGroup->type,
                'position' => $stepGroup->position,
            ];
        })->toArray();
        
        // Check access
        $debug['can_access'] = $this->canUserAccessApplication($application, $user);
        $debug['can_submit'] = $this->canUserSubmitApplication($application, $user);
        $debug['can_approve'] = $this->canUserApproveApplication($application, $user);
        
        // Check if any of user's groups match step groups
        $userGroupIds = $userGroups->pluck('map_pass_group_id')->toArray();
        $stepGroupIds = $stepGroups->pluck('map_pass_group_id')->toArray();
        $debug['matching_groups'] = array_intersect($userGroupIds, $stepGroupIds);
        
        // Get step record status
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $currentStep->id)
            ->first();
        $debug['step_status'] = $stepRecord ? $stepRecord->status : 'not_created';
        
        return $debug;
    }

    /**
     * Legacy method for backward compatibility
     */
    public function filterApplicationsByUserRoles(Builder $query, $applicationType = null): Builder
    {
        return $this->filterApplicationsByUserGroups($query, $applicationType);
    }

    /**
     * Check if user is a submitter for the current step of an application
     */
    public function isUserSubmitterForCurrentStep(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always submit
        if (isSuperAdmin()) {
            return true;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        return $currentStep->canUserSubmit($user);
    }

    /**
     * Check if user is an approver for the current step of an application
     */
    public function isUserApproverForCurrentStep(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always approve
        if (isSuperAdmin()) {
            return true;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        return $currentStep->canUserApprove($user);
    }

    /**
     * Check if user can access the current step of an application
     */
    public function canUserAccessCurrentStep(MapApply $application, $user = null): bool
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return false;
        }

        // Superadmin can always access
        if (isSuperAdmin()) {
            return true;
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return false;
        }

        return $currentStep->canUserAccess($user);
    }

    /**
     * Get the type of access the user has for the current step (submitter, approver, or both)
     */
    public function getUserAccessTypeForCurrentStep(MapApply $application, $user = null): array
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return ['submitter' => false, 'approver' => false];
        }

        // Superadmin has all access
        if (isSuperAdmin()) {
            return ['submitter' => true, 'approver' => true];
        }

        $currentStep = $this->getCurrentStep($application);
        
        if (!$currentStep) {
            return ['submitter' => false, 'approver' => false];
        }

        return [
            'submitter' => $currentStep->canUserSubmit($user),
            'approver' => $currentStep->canUserApprove($user)
        ];
    }
} 