<?php

namespace Src\Employees\Service;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Employees\Models\Employee;

class EmployeeService
{
    public function showEmployeeList(): Collection
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFilters(['phone', 'name', 'type', 'ward_no', 'address', 'gender', 'is_department_head'])
            ->with('branch', 'designation')
            ->allowedSorts(['name', 'email', 'created_at', 'position', 'type'])
            ->get();


        return $employees;
    }
    
}
