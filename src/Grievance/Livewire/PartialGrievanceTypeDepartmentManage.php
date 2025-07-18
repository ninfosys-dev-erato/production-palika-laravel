<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Grievance\Models\GrievanceType;

class PartialGrievanceTypeDepartmentManage extends Component
{
    use SessionFlash;

    public ?GrievanceType $type;
    public $departments = [];
    #[Modelable]
    public $selectedDepartments = [];

    public function mount(GrievanceType $grievanceType)
    {
        $this->type = $grievanceType;
        $this->departments = Branch::select('id', 'title', 'title_en')->get()->toArray();
        $this->selectedDepartments = $this->type->departments?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.partial-manage-department", [
            'type' => $this->type,
        ]);
    }

}
