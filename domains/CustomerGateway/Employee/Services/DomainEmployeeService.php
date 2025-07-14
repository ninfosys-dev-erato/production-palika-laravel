<?php

namespace Domains\CustomerGateway\Employee\Services;

use Illuminate\Database\Eloquent\Collection;
use Src\Employees\Service\EmployeeService;

class DomainEmployeeService
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function show(): Collection
    {
        return $this->employeeService->showEmployeeList();
    }

}