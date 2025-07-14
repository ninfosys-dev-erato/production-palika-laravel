<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\Grievance\Models\GrievanceType;
use Src\Roles\Models\Role;

class PartialGrievanceTypeRoleManage extends Component
{
    use SessionFlash;

    
    public ?GrievanceType $grievanceType;
    public $roles = [];
    #[Modelable]
    public $selectedRoles = [];

    public function mount(GrievanceType $grievanceType)
    {
        $this->grievanceType = $grievanceType;
        $this->roles = Role::where('name', '!=', 'super-admin')->get();
        $this->selectedRoles = $this->grievanceType->roles?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.partial-manage-notifee");
    }
}
