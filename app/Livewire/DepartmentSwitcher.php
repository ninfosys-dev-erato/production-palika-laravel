<?php

namespace App\Livewire;

use App\Facades\GlobalFacade;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DepartmentSwitcher extends Component
{
    protected $listeners = ['changeDepartment'];
    
    public $ward;

    public function mount()
    {
        $this->ward = GlobalFacade::ward();

        // Set default department if not already set
        if (!session()->has('department')) {
            $defaultDepartment = auth()->user()->departments()->first();
            if ($defaultDepartment) {
                session(['department' => $defaultDepartment->id]);
                // Clear the cache to force refresh
                Cache::forget('user_departments_' . auth()->id());
            }
        }
    }

    public function changeDepartment(int $department)
    {
        GlobalFacade::department($department);
        // Clear the cache to force refresh
        Cache::forget('user_departments_' . auth()->id());
        $this->dispatch('department-change');
    }

    public function render()
    {
        return view('livewire.department-switcher');
    }
}
