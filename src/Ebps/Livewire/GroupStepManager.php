<?php

namespace Src\Ebps\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\DTO\GroupStepDto;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\GroupStepService;
use Src\Ebps\Models\MapPassGroup;

class GroupStepManager extends Component
{
    use SessionFlash;

    public MapStep $mapStep;
    public ?int $submitterGroupId = null;
    public array $approverGroupIds = [];
    public array $availableGroups = [];
    public bool $showSubmitterGroups = false;

    protected $rules = [
        'submitterGroupId' => 'nullable|exists:ebps_map_pass_groups,id',
        'approverGroupIds.*' => 'nullable|exists:ebps_map_pass_groups,id',
    ];

    public function mount(MapStep $mapStep)
    {
        $this->mapStep = $mapStep;
        $this->determineSubmitterVisibility();
        $this->loadAvailableGroups();
        $this->loadStepGroups();
    }

    public function render()
    {
        return view('Ebps::livewire.group-step.group-step-manager');
    }

    public function loadStepGroups()
    {
        $groupStepService = new GroupStepService();
        $groups = $groupStepService->getStepGroups($this->mapStep);
        
        $this->submitterGroupId = $groups['submitter_groups'][0] ?? null;
        $this->approverGroupIds = $groups['approver_groups'];
        
        // Ensure we have at least one empty group if none exist
        if (empty($this->approverGroupIds)) {
            $this->approverGroupIds = [''];
        }
    }

    public function loadAvailableGroups()
    {
        $groupStepService = new GroupStepService();
        $this->availableGroups = $groupStepService->getAvailableGroups();
    }

    public function determineSubmitterVisibility()
    {
        // Show submitter groups only for Palika type steps
        $this->showSubmitterGroups = $this->mapStep->form_submitter === 'Palika';
    }

    public function addApproverGroup()
    {
        $this->approverGroupIds[] = '';
    }

    public function removeApproverGroup($index)
    {
        if (isset($this->approverGroupIds[$index])) {
            unset($this->approverGroupIds[$index]);
            $this->approverGroupIds = array_values($this->approverGroupIds);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $groupStepService = new GroupStepService();
            
            // Filter out null/empty values and convert to integers
            $approverGroups = array_filter($this->approverGroupIds, function($groupId) {
                return !is_null($groupId) && $groupId !== '' && is_numeric($groupId);
            });
            $approverGroups = array_map('intval', $approverGroups);
            
            \Log::info('Saving groups', [
                'submitter_group' => $this->submitterGroupId,
                'approver_groups' => array_values($approverGroups),
                'step_id' => $this->mapStep->id
            ]);
            
            $groupStepService->assignGroupsToStep(
                $this->mapStep,
                $this->submitterGroupId,
                array_values($approverGroups)
            );

            $this->successFlash(__('ebps::ebps.step_groups_updated_successfully'));
            
            // Reload the groups to show updated state
            $this->loadStepGroups();
            
            // Force Livewire to re-render
            $this->render();
            
        } catch (\Exception $e) {
            \Log::error('Error saving step groups', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorFlash(__('ebps::ebps.error_updating_step_groups') . ': ' . $e->getMessage());
        }
    }

    public function refresh()
    {
        // Refresh the component data
        $this->loadStepGroups();
        $this->loadAvailableGroups();
    }

    public function getGroupTitle($groupId)
    {
        if (!$groupId) return '';
        
        $group = MapPassGroup::find($groupId);
        return $group ? $group->title : '';
    }

    public function getSubmitterUsers()
    {
        if (!$this->submitterGroupId) {
            return collect();
        }

        $group = MapPassGroup::find($this->submitterGroupId);
        return $group ? $group->getUsers() : collect();
    }

    public function getApproverUsers()
    {
        $users = collect();
        
        foreach ($this->approverGroupIds as $groupId) {
            if ($groupId) {
                $group = MapPassGroup::find($groupId);
                if ($group) {
                    $users = $users->merge($group->getUsers());
                }
            }
        }
        
        return $users->unique('id');
    }
} 