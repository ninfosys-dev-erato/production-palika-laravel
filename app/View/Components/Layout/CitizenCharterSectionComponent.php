<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\Employees\Models\Employee;

class CitizenCharterSectionComponent extends Component
{
    public $employees;
    public $representatives;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $charters = CitizenCharter::with('wards', 'branch')
            ->get();
  
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.employee-section-component', [
            'employees' => $this->employees,
            'representatives' => $this->representatives,
        ]);
    }
}
