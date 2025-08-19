<?php

namespace Src\Ebps\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\DTO\StepRoleDto;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\StepRoleService;
use Spatie\Permission\Models\Role;

class StepRoleManager extends Component
{
    use SessionFlash;

    public MapStep $mapStep;
    public array $submitterRoleIds = [];
    public array $approverRoleIds = [];
    public array $availableRoles = [];
    public bool $showSubmitterRoles = false;

    protected $rules = [
        'submitterRoleIds.*' => 'nullable|exists:roles,id',
        'approverRoleIds.*' => 'nullable|exists:roles,id',
    ];

    public function mount(MapStep $mapStep)
    {
        $this->mapStep = $mapStep;
        $this->determineSubmitterVisibility();
        $this->loadAvailableRoles();
        $this->loadStepRoles();
    }

    public function render()
    {
        return view('Ebps::livewire.step-role.step-role-manager');
    }

    public function loadStepRoles()
    {
        $stepRoleService = new StepRoleService();
        $roles = $stepRoleService->getStepRoles($this->mapStep);
        
        // Convert to strings to match HTML form values
        $this->submitterRoleIds = array_map('strval', $roles['submitter_roles']);
        $this->approverRoleIds = array_map('strval', $roles['approver_roles']);
        
        // Debug information
        \Log::info('Loaded step roles', [
            'submitter_roles' => $this->submitterRoleIds,
            'approver_roles' => $this->approverRoleIds,
            'step_id' => $this->mapStep->id
        ]);
        
        // Ensure we have at least one empty role if none exist
        if (empty($this->submitterRoleIds) && $this->showSubmitterRoles) {
            $this->submitterRoleIds = [''];
        }
        if (empty($this->approverRoleIds)) {
            $this->approverRoleIds = [''];
        }
    }

    public function loadAvailableRoles()
    {
        $stepRoleService = new StepRoleService();
        $this->availableRoles = $stepRoleService->getAvailableRoles();
        
      
    }

    public function determineSubmitterVisibility()
    {
        // Show submitter roles only if form_submitter is 'Palika'
        $this->showSubmitterRoles = $this->mapStep->form_submitter === 'Palika';
        
       
    }

    public function addSubmitterRole()
    {
        $this->submitterRoleIds[] = '';
    }

    public function removeSubmitterRole($index)
    {
        unset($this->submitterRoleIds[$index]);
        $this->submitterRoleIds = array_values($this->submitterRoleIds);
    }

    public function addApproverRole()
    {
        $this->approverRoleIds[] = '';
    }

    public function removeApproverRole($index)
    {
        unset($this->approverRoleIds[$index]);
        $this->approverRoleIds = array_values($this->approverRoleIds);
    }

    public function save()
    {
        $this->validate();

        try {
            $stepRoleService = new StepRoleService();
            
            // Filter out null/empty values and convert to integers
            $submitterRoles = array_filter($this->submitterRoleIds, function($roleId) {
                return !is_null($roleId) && $roleId !== '' && is_numeric($roleId);
            });
            $submitterRoles = array_map('intval', $submitterRoles);
            
            $approverRoles = array_filter($this->approverRoleIds, function($roleId) {
                return !is_null($roleId) && $roleId !== '' && is_numeric($roleId);
            });
            $approverRoles = array_map('intval', $approverRoles);
            
            \Log::info('Saving roles', [
                'submitter_roles' => array_values($submitterRoles),
                'approver_roles' => array_values($approverRoles),
                'step_id' => $this->mapStep->id
            ]);
            
            $stepRoleService->assignRolesToStep(
                $this->mapStep,
                array_values($submitterRoles),
                array_values($approverRoles)
            );

            $this->successFlash(__('ebps::ebps.step_roles_updated_successfully'));
            
            // Reload the roles to show updated state
            $this->loadStepRoles();
            
            // Force Livewire to re-render
            $this->render();
            
        } catch (\Exception $e) {
            \Log::error('Error saving step roles', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorFlash(__('ebps::ebps.error_updating_step_roles') . ': ' . $e->getMessage());
        }
    }

    public function refresh()
    {
        // Refresh the component data
        $this->loadStepRoles();
        $this->loadAvailableRoles();
    }

    public function getRoleName($roleId)
    {
        if (!$roleId) return '';
        
        $role = Role::find($roleId);
        return $role ? $role->name : '';
    }

    /**
     * Get filtered roles for a specific dropdown
     * Excludes roles that are already selected in OTHER dropdowns of the same type
     */
    public function getFilteredRolesForDropdown($currentRoleType, $currentIndex)
    {
        $selectedRoles = [];
        
        if ($currentRoleType === 'submitter') {
            // Get all other selected submitter roles (excluding current index)
            foreach ($this->submitterRoleIds as $index => $roleId) {
                if ($index !== $currentIndex && $roleId && $roleId !== '') {
                    $selectedRoles[] = $roleId;
                }
            }
        } else {
            // Get all other selected approver roles (excluding current index)
            foreach ($this->approverRoleIds as $index => $roleId) {
                if ($index !== $currentIndex && $roleId && $roleId !== '') {
                    $selectedRoles[] = $roleId;
                }
            }
        }
        
        return collect($this->availableRoles)
            ->filter(function ($role) use ($selectedRoles) {
                return !in_array($role['id'], $selectedRoles);
            })
            ->toArray();
    }

    public function getFilteredRoles($excludeIds = [])
    {
        return collect($this->availableRoles)
            ->filter(function ($role) use ($excludeIds) {
                return !in_array($role['id'], $excludeIds);
            })
            ->toArray();
    }

    // Make the method available to the view
    public function getFilteredRolesForView($excludeIds = [])
    {
        return $this->getFilteredRoles($excludeIds);
    }
    
    // Get all available roles (for dropdown display)
    public function getAllAvailableRoles()
    {
        return $this->availableRoles;
    }
} 