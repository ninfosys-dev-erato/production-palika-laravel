<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Grievance\Models\GrievanceType;

class GrievanceTypeDepartmentManage extends Component
{
    use SessionFlash;

    public ?GrievanceType $grievanceType;
    public $departments = [];
    public $selectedDepartments = [];

    public function mount(GrievanceType $grievanceType)
    {
        $this->grievanceType = $grievanceType;
        $this->departments = Branch::select('id', 'title', 'title_en')->get()->toArray();
        $this->selectedDepartments = $this->grievanceType->branches?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.manage-department", [
            'type' => $this->grievanceType,
        ]);
    }

    public function syncDepartments()
    {
        $this->grievanceType->branches()->sync($this->selectedDepartments);
        $this->successFlash(__('grievance::grievance.department_synced_successfully'));
    }
}
