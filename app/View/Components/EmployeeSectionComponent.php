<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Src\Employees\Models\Employee;

class EmployeeSectionComponent extends Component
{
    public $employees;
    public $representatives;

    public function __construct()
    {
        $this->employees = Cache::remember('employees_section', 3600, function () {
            $employees = Employee::with('designation')
                ->whereIn('type', ['temporary staff', 'permanent staff'])
                ->orderBy('position')
                ->get();

            foreach ($employees as $employee) {
                $employee->cached_photo_url = Cache::remember(
                    "employee-photo-url-{$employee->id}",
                    3600,
                    function () use ($employee) {
                        return customFileAsset(
                            config('src.Employees.employee.photo_path'),
                            $employee->photo,
                            'local',
                            'tempUrl'
                        );
                    }
                );
            }

            return $employees;
        });

        $this->representatives = Cache::remember('representatives_section', 3600, function () {
            $representatives = Employee::with('designation')
                ->where('type', 'representative')
                ->orderBy('position')
                ->get();

            foreach ($representatives as $rep) {
                $rep->cached_photo_url = Cache::remember(
                    "representative-photo-url-{$rep->id}",
                    3600,
                    function () use ($rep) {
                        return customFileAsset(
                            config('src.Employees.employee.photo_path'),
                            $rep->photo,
                            'local',
                            'tempUrl'
                        );
                    }
                );
            }

            return $representatives;
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.employee-section-component', [
            'employees' => $this->employees,
            'representatives' => $this->representatives,
        ]);
    }
}
