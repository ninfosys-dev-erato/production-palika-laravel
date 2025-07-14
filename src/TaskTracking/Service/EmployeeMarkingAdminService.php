<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\EmployeeMarkingAdminDto;
use Src\TaskTracking\Models\EmployeeMarking;

class EmployeeMarkingAdminService
{
    public function store(EmployeeMarkingAdminDto $employeeMarkingAdminDto)
    {
        return EmployeeMarking::create([
            // 'employee_id' => $employeeMarkingAdminDto->employee_id,
            // 'anusuchi_id' => $employeeMarkingAdminDto->anusuchi_id,
            // 'score' => $employeeMarkingAdminDto->score,
            // 'fiscal_year' => $employeeMarkingAdminDto->fiscal_year,
            // 'period_title' => $employeeMarkingAdminDto->period_title,
            // 'period_type' => $employeeMarkingAdminDto->period_type,
            // 'date_from' => $employeeMarkingAdminDto->date_from,
            // 'date_to' => $employeeMarkingAdminDto->date_to,
            // 'created_at' => date('Y-m-d H:i:s'),
            // 'created_by' => Auth::user()->id,
            'employee_id' => $employeeMarkingAdminDto->employee_id,
            'anusuchi_id' => $employeeMarkingAdminDto->anusuchi_id,
            'full_score' => $employeeMarkingAdminDto->full_score,
            'obtained_score' => $employeeMarkingAdminDto->obtained_score,
            'fiscal_year' => $employeeMarkingAdminDto->fiscal_year,
            'period_type' => $employeeMarkingAdminDto->period_type,
            'date_from' => $employeeMarkingAdminDto->date_from,
            'date_to' => $employeeMarkingAdminDto->date_to,
            'month' => $employeeMarkingAdminDto->month,
            'created_at' => date('Y-m-d H:i:s'),
            // 'created_by' => Auth::user()->id,
        ]);
    }
    public function update(EmployeeMarking $employeeMarking, EmployeeMarkingAdminDto $employeeMarkingAdminDto)
    {
        return tap($employeeMarking)->update([
            'employee_id' => $employeeMarkingAdminDto->employee_id,
            'anusuchi_id' => $employeeMarkingAdminDto->anusuchi_id,
            'full_score' => $employeeMarkingAdminDto->full_score,
            'obtained_score' => $employeeMarkingAdminDto->obtained_score,
            'fiscal_year' => $employeeMarkingAdminDto->fiscal_year,
            'period_type' => $employeeMarkingAdminDto->period_type,
            'date_from' => $employeeMarkingAdminDto->date_from,
            'date_to' => $employeeMarkingAdminDto->date_to,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(EmployeeMarking $employeeMarking)
    {
        return tap($employeeMarking)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        EmployeeMarking::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
