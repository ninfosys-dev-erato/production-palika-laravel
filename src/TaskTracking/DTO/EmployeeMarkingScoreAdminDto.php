<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\EmployeeMarkingScore;

class EmployeeMarkingScoreAdminDto
{
    public function __construct(
        public string $employee_marking_id,
        public string $employee_id,
        public string $anusuchi_id,
        public string $criteria_id,
        public ?string $score_obtained,
        public ?string $score_out_of,
        public ?string $remarks
    ) {}

    public static function fromLiveWireModel(EmployeeMarkingScore $employeeMarkingScore): EmployeeMarkingScoreAdminDto
    {
        return new self(
            employee_marking_id: $employeeMarkingScore->employee_marking_id,
            employee_id: $employeeMarkingScore->employee_id,
            anusuchi_id: $employeeMarkingScore->anusuchi_id,
            criteria_id: $employeeMarkingScore->criteria_id,
            score_obtained: $employeeMarkingScore->score_obtained,
            score_out_of: $employeeMarkingScore->score_out_of,
            remarks: $employeeMarkingScore->remarks
        );
    }
    public static function fromArray(array $data): self
    {
        return new self(
            employee_marking_id: $data['employee_marking_id'],
            employee_id: $data['employee_id'],
            anusuchi_id: $data['anusuchi_id'],
            criteria_id: $data['criteria_id'],
            score_obtained: $data['score_obtained'],
            score_out_of: $data['score_out_of'],
            remarks: $data['remarks']
        );
    }
}
