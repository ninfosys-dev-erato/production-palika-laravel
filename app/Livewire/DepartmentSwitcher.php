<?php

namespace App\Livewire;

use App\Facades\GlobalFacade;
use Livewire\Component;

class DepartmentSwitcher extends Component
{
    protected $listeners = ['changeDepartment'];
    
    public $ward;

    public function mount()
    {
        $this->ward = GlobalFacade::ward();

        if (!session()->has('department')) {
            $defaultDepartment = auth()->user()->departments()->first();
            if ($defaultDepartment) {
                session(['department' => $defaultDepartment->id]);
            }
        }
    }

    public function changeDepartment(int $ward)
    {
       GlobalFacade::department($ward);
        $this->dispatch('department-change');
    }

    public function render()
    {
        return view('livewire.department-switcher');
    }
}
