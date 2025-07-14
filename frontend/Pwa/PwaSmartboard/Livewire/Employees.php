<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Livewire\Component;
use Src\Employees\Models\Employee;
use Illuminate\Support\Collection;

class Employees extends Component
{
    public Collection $employees;
    public int $ward;
    public function mount($ward = 0)
    {
        $this->employees = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();
    }


    public function goBack()
    {
        if ($this->ward > 0) {
            return redirect()->route('smartboard.index', ['ward' => $this->ward]);
        }
        return redirect()->route('smartboard.index');
    }


    public function render()
    {
        return view("Pwa.PwaSmartboard::livewire.employee-details");
    }
}
