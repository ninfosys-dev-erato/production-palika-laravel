<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\Models\GrievanceType;
use Src\Roles\Models\Role;

class GrievanceTypeRoleManage extends Component
{
    use SessionFlash;


    public ?GrievanceType $type;
    public $roles = [];
    public $selectedRoles = [];

    public function mount(GrievanceType $grievanceType)
    {
        $this->type = $grievanceType;
        $this->roles = Role::where('name', '!=', 'super-admin')->get();
        $this->selectedRoles = $this->type->roles?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.manage-notifee", [
            'type' => $this->type,
        ]);
    }

    public function syncRoles()
    {
        $this->type->roles()->sync($this->selectedRoles);
        $this->successFlash(__('grievance::grievance.notifee_have_been_synced_successfully'));
    }
}
