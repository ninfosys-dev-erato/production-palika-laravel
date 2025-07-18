<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Src\Employees\Models\Employee;

class EmployeeSectionComponent extends Component
{
    public $employees;
    public $representatives;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->employees = Employee::with('designation')
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();

        $this->representatives = Employee::with('designation')
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.employee-section-component', [
            'employees' => $this->employees->sortBy('position'),
            'representatives' => $this->representatives->sortBy('position'),
        ]);
    }
}
