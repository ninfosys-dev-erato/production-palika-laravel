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
     * Filter applications query based on current user's roles and step access
     */
    public function filterApplicationsByUserRoles(Builder $query, $applicationType = null): Builder
    {
        // Check if role filtering is enabled for this municipality
        if (!\Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled()) {
            // Role filtering is disabled, return all applications
            return $query;
        }

        // Role filtering is enabled, apply the strict filtering
        $user = Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // Return no results if no user
        }

        // Superadmin should see everything regardless of role filtering
        if (isSuperAdmin()) {
            return $query;
        }

        $userRoles = $user->getRoleNames()->toArray();
        
        
        if (empty($userRoles)) {
            return $query->whereRaw('1 = 0'); // Return no results if user has no roles
        }

        // Get steps that user can access (either submit or approve)
        $accessibleSteps = MapStep::whereHas('stepRoles', function ($stepRoleQuery) use ($userRoles) {
            $stepRoleQuery->active()
                ->whereHas('role', function ($roleQuery) use ($userRoles) {
                    $roleQuery->whereIn('name', $userRoles);
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
            ->orderBy('form_position')
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

        // If role filtering is disabled, allow access
        if (!\Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled()) {
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

        // If role filtering is disabled, allow access
        if (!\Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled()) {
            return true;
        }

        // Check if user has any role that can access this step (submit or approve)
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

        // If role filtering is disabled, allow action
        if (!\Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled()) {
            return true;
        }

        // Check if user can submit or approve this specific step
        return $step->canUserSubmit($user) || $step->canUserApprove($user);
    }

    /**
     * Enhanced method to filter applications based on current step and user roles
     */
    public function filterApplicationsByCurrentStepAccess(Builder $query, $applicationType = null): Builder
    {
        // Check if role filtering is enabled for this municipality
        if (!\Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled()) {
            // Role filtering is disabled, return all applications
            return $query;
        }

        // Role filtering is enabled, apply the strict filtering
        $user = Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // Return no results if no user
        }

        // Superadmin should see everything regardless of role filtering
        if (isSuperAdmin()) {
            return $query;
        }

        $userRoles = $user->getRoleNames()->toArray();
        
        if (empty($userRoles)) {
            return $query->whereRaw('1 = 0'); // Return no results if user has no roles
        }

        // Filter applications where user can access the current step
        return $query->whereExists(function ($subQuery) use ($userRoles, $applicationType) {
            $subQuery->selectRaw('1')
                ->from('ebps_map_applies as current_app')
                ->whereColumn('current_app.id', 'ebps_map_applies.id')
                ->whereExists(function ($stepQuery) use ($userRoles, $applicationType) {
                    $stepQuery->selectRaw('1')
                        ->from('ebps_map_steps as current_step')
                        ->where('current_step.application_type', $applicationType)
                        ->whereExists(function ($roleQuery) use ($userRoles) {
                            $roleQuery->selectRaw('1')
                                ->from('ebps_step_roles as sr')
                                ->whereColumn('sr.map_step_id', 'current_step.id')
                                ->where('sr.is_active', true)
                                ->whereExists(function ($userRoleQuery) use ($userRoles) {
                                    $userRoleQuery->selectRaw('1')
                                        ->from('roles as r')
                                        ->whereColumn('r.id', 'sr.role_id')
                                        ->whereIn('r.name', $userRoles);
                                });
                        })
                        ->where(function ($currentStepQuery) {
                            // This step is the current step (either not started or not accepted)
                            $currentStepQuery->whereNotExists(function ($appliedStepQuery) {
                                $appliedStepQuery->selectRaw('1')
                                    ->from('ebps_map_apply_steps as applied')
                                    ->whereColumn('applied.map_step_id', 'current_step.id')
                                    ->whereColumn('applied.map_apply_id', 'current_app.id');
                            })->orWhereExists(function ($pendingStepQuery) {
                                $pendingStepQuery->selectRaw('1')
                                    ->from('ebps_map_apply_steps as pending')
                                    ->whereColumn('pending.map_step_id', 'current_step.id')
                                    ->whereColumn('pending.map_apply_id', 'current_app.id')
                                    ->where('pending.status', '!=', 'accepted');
                            });
                        })
                        ->orderBy('current_step.form_position')
                        ->limit(1);
                });
        });
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
     * Get action buttons for an application based on user roles
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
            ->orderBy('form_position')
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
        
        $userRoles = $user->getRoleNames()->toArray();
        $debug['user_roles'] = $userRoles;
        
        if (empty($userRoles)) {
            $debug['error'] = 'User has no roles assigned';
            return $debug;
        }
        
        // Get current step
        $currentStep = $this->getCurrentStep($application);
        $debug['current_step'] = $currentStep ? [
            'id' => $currentStep->id,
            'title' => $currentStep->title,
            'form_position' => $currentStep->form_position,
        ] : null;
        
        if (!$currentStep) {
            $debug['error'] = 'No current step found';
            return $debug;
        }
        
        // Check step roles
        $stepRoles = $currentStep->stepRoles()->active()->with('role')->get();
        $debug['step_roles'] = $stepRoles->map(function($stepRole) {
            return [
                'role_name' => $stepRole->role->name,
                'role_type' => $stepRole->role_type,
                'position' => $stepRole->position,
            ];
        })->toArray();
        
        // Check access
        $debug['can_access'] = $this->canUserAccessApplication($application, $user);
        $debug['can_submit'] = $this->canUserSubmitApplication($application, $user);
        $debug['can_approve'] = $this->canUserApproveApplication($application, $user);
        
        // Check if any of user's roles match step roles
        $stepRoleNames = $stepRoles->pluck('role.name')->toArray();
        $debug['matching_roles'] = array_intersect($userRoles, $stepRoleNames);
        
        // Get step record status
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $currentStep->id)
            ->first();
        $debug['step_status'] = $stepRecord ? $stepRecord->status : 'not_created';
        
        return $debug;
    }
} 