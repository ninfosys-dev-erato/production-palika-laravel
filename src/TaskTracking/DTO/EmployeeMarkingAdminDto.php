<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\EmployeeMarking;

class EmployeeMarkingAdminDto
{
    public function __construct(
        public string $employee_id,
        public string $anusuchi_id,
        public string $full_score,
        public string $obtained_score,
        public string $fiscal_year,
        public string $period_type,
        public string $date_from,
        public string $date_to,
        public ?string $month = null
    ) {}

    public static function fromLiveWireModel(EmployeeMarking $employeeMarking): EmployeeMarkingAdminDto
    {
        return new self(
            employee_id: $employeeMarking->employee_id,
            anusuchi_id: $employeeMarking->anusuchi_id,
            full_score: $employeeMarking->full_score,
            obtained_score: $employeeMarking->obtained_score,
            fiscal_year: $employeeMarking->fiscal_year,
            period_type: $employeeMarking->period_type,
            date_from: $employeeMarking->date_from,
            date_to: $employeeMarking->date_to,
            month: $employeeMarking->month,
        );
    }
}
