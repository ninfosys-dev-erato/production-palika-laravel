<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Models\StepRole;
use Spatie\Permission\Models\Role;

class StepRoleService
{
    /**
     * Assign roles to a step
     */
    public function assignRolesToStep(MapStep $step, array $submitterRoleIds = [], array $approverRoleIds = []): void
    {
        DB::transaction(function () use ($step, $submitterRoleIds, $approverRoleIds) {
            // Remove existing roles for this step
            $step->stepRoles()->delete();

            // Add submitter roles
            foreach ($submitterRoleIds as $position => $roleId) {
                if ($roleId) {
                    StepRole::create([
                        'map_step_id' => $step->id,
                        'role_id' => $roleId,
                        'role_type' => 'submitter',
                        'position' => $position + 1,
                        'is_active' => true,
                        // 'created_by' => Auth::user()->id,
                    ]);
                }
            }

            // Add approver roles
            foreach ($approverRoleIds as $position => $roleId) {
                if ($roleId) {
                    StepRole::create([
                        'map_step_id' => $step->id,
                        'role_id' => $roleId,
                        'role_type' => 'approver',
                        'position' => $position + 1,
                        'is_active' => true,
                        // 'created_by' => Auth::user()->id,
                    ]);
                }
            }
        });
    }

    /**
     * Get available roles for dropdown
     */
    public function getAvailableRoles(): array
    {
        return Role::whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                ];
            })
            ->toArray();
    }

    /**
     * Get roles for a specific step
     */
    public function getStepRoles(MapStep $step): array
    {
        $submitterRoles = $step->submitterRoles()
            ->with('role')
            ->orderBy('position')
            ->get()
            ->pluck('role_id')
            ->toArray();

        $approverRoles = $step->approverRoles()
            ->with('role')
            ->orderBy('position')
            ->get()
            ->pluck('role_id')
            ->toArray();

        return [
            'submitter_roles' => $submitterRoles,
            'approver_roles' => $approverRoles,
        ];
    }

    /**
     * Get steps accessible by a user
     */
    public function getAccessibleSteps($user, $applicationType = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = MapStep::active()->accessibleByUser($user);

        if ($applicationType) {
            $query->forApplicationType($applicationType);
        }

        return $query->with(['submitterRoles.role', 'approverRoles.role'])
            ->orderBy('form_position')
            ->get();
    }

    /**
     * Check if user can access a specific step
     */
    public function canUserAccessStep($user, MapStep $step): bool
    {
        return $step->canUserAccess($user);
    }

    /**
     * Check if user can submit a specific step
     */
    public function canUserSubmitStep($user, MapStep $step): bool
    {
        return $step->canUserSubmit($user);
    }

    /**
     * Check if user can approve a specific step
     */
    public function canUserApproveStep($user, MapStep $step): bool
    {
        return $step->canUserApprove($user);
    }

    /**
     * Get steps that require submitter roles based on form_submitter
     */
    public function getStepsRequiringSubmitterRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return MapStep::where('form_submitter', 'Palika')
            ->active()
            ->get();
    }

    /**
     * Get steps that don't require submitter roles
     */
    public function getStepsNotRequiringSubmitterRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return MapStep::whereIn('form_submitter', ['Consultancy', 'Ghardhani'])
            ->active()
            ->get();
    }
} 