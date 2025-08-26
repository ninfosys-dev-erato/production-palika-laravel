<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Models\MapPassGroup;
use Src\Ebps\Models\MapPassGroupMapStep;

class GroupStepService
{
    /**
     * Assign groups to a step
     */
    public function assignGroupsToStep(MapStep $step, ?int $submitterGroupId = null, array $approverGroupIds = []): void
    {
        DB::transaction(function () use ($step, $submitterGroupId, $approverGroupIds) {
            // Remove existing group assignments for this step
            $step->mapPassGroupMapSteps()->delete();

            // Add submitter group (only one allowed)
            if ($submitterGroupId) {
                MapPassGroupMapStep::create([
                    'map_step_id' => $step->id,
                    'map_pass_group_id' => $submitterGroupId,
                    'type' => 'submitter',
                    'position' => 1,
                    'created_by' => Auth::user()->id,
                ]);
            }

            // Add approver groups (multiple allowed)
            foreach ($approverGroupIds as $position => $groupId) {
                if ($groupId) {
                    MapPassGroupMapStep::create([
                        'map_step_id' => $step->id,
                        'map_pass_group_id' => $groupId,
                        'type' => 'approver',
                        'position' => $position + 1,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }
        });
    }

    /**
     * Get available groups for dropdown
     */
    public function getAvailableGroups(): array
    {
        return MapPassGroup::whereNull('deleted_at')
            ->orderBy('title')
            ->get()
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'title' => $group->title,
                ];
            })
            ->toArray();
    }

    /**
     * Get groups for a specific step
     */
    public function getStepGroups(MapStep $step): array
    {
        $submitterGroups = $step->submitterGroups()
            ->orderBy('position')
            ->get()
            ->pluck('id')
            ->toArray();

        $approverGroups = $step->approverGroups()
            ->orderBy('position')
            ->get()
            ->pluck('id')
            ->toArray();

        return [
            'submitter_groups' => $submitterGroups,
            'approver_groups' => $approverGroups,
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

        return $query->with(['submitterGroups.users.user', 'approverGroups.users.user'])
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
     * Get steps that require submitter groups based on form_submitter
     */
    public function getStepsRequiringSubmitterGroups(): \Illuminate\Database\Eloquent\Collection
    {
        return MapStep::where('form_submitter', 'Palika')
            ->active()
            ->get();
    }

    /**
     * Get steps that don't require submitter groups
     */
    public function getStepsNotRequiringSubmitterGroups(): \Illuminate\Database\Eloquent\Collection
    {
        return MapStep::whereIn('form_submitter', ['Consultancy', 'Ghardhani'])
            ->active()
            ->get();
    }

    /**
     * Get users who can submit a specific step
     */
    public function getStepSubmitterUsers(MapStep $step)
    {
        return $step->getSubmitterUsers();
    }

    /**
     * Get users who can approve a specific step
     */
    public function getStepApproverUsers(MapStep $step)
    {
        return $step->getApproverUsers();
    }

    /**
     * Get all steps with their group assignments
     */
    public function getAllStepsWithGroups($applicationType = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = MapStep::active()
            ->with(['submitterGroups.users.user', 'approverGroups.users.user']);

        if ($applicationType) {
            $query->forApplicationType($applicationType);
        }

        return $query->orderBy('form_position')->get();
    }

    /**
     * Get groups that are assigned to any step
     */
    public function getGroupsAssignedToSteps(): \Illuminate\Database\Eloquent\Collection
    {
        return MapPassGroup::whereHas('mapPassGroupMapSteps')
            ->whereNull('deleted_at')
            ->with(['mapPassGroupMapSteps.mapStep'])
            ->get();
    }

    /**
     * Get steps for a specific group
     */
    public function getStepsForGroup(MapPassGroup $group, $type = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = $group->steps()->active();

        if ($type) {
            $query->wherePivot('type', $type);
        }

        return $query->orderBy('form_position')->get();
    }
} 