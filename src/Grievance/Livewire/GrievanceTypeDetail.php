<?php

namespace Src\Grievance\Livewire;

use Livewire\Component;
use Src\Grievance\Models\GrievanceType;

class GrievanceTypeDetail extends Component
{
    public ?GrievanceType $grievanceType;

    public function mount(GrievanceType $grievanceType)
    {
        $this->grievanceType = $grievanceType;
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.detail", ['grievanceType' => $this->grievanceType]);
    }
}
