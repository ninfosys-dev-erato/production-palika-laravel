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
