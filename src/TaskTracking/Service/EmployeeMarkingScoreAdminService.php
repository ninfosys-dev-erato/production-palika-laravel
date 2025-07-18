<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\EmployeeMarkingScoreAdminDto;
use Src\TaskTracking\Models\EmployeeMarkingScore;

class EmployeeMarkingScoreAdminService
{
    // public function store(EmployeeMarkingScoreAdminDto $employeeMarkingScoreAdminDto)
    // {
    //     return EmployeeMarkingScore::create([
    //         'employee_marking_id' => $employeeMarkingScoreAdminDto->employee_marking_id,
    //         'criteria_id' => $employeeMarkingScoreAdminDto->criteria_id,
    //         'score_obtained' => $employeeMarkingScoreAdminDto->score_obtained,
    //         'score_out_of' => $employeeMarkingScoreAdminDto->score_out_of,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'created_by' => Auth::user()->id,
    //     ]);
    // }

    public function store(EmployeeMarkingScoreAdminDto $employeeMarkingScoreAdminDto)
    {
        return EmployeeMarkingScore::create([
            'employee_marking_id' => $employeeMarkingScoreAdminDto->employee_marking_id,
            'employee_id'         => $employeeMarkingScoreAdminDto->employee_id,
            'anusuchi_id'         => $employeeMarkingScoreAdminDto->anusuchi_id,
            'criteria_id'         => $employeeMarkingScoreAdminDto->criteria_id,
            'score_obtained'      => $employeeMarkingScoreAdminDto->score_obtained,
            'score_out_of'        => $employeeMarkingScoreAdminDto->score_out_of,
            'remarks'             => $employeeMarkingScoreAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            // 'created_by' => Auth::user()->id,
        ]);
    }

    public function update(EmployeeMarkingScore $employeeMarkingScore, EmployeeMarkingScoreAdminDto $employeeMarkingScoreAdminDto)
    {
        return tap($employeeMarkingScore)->update([
            'employee_marking_id' => $employeeMarkingScoreAdminDto->employee_marking_id,
            'criteria_id' => $employeeMarkingScoreAdminDto->criteria_id,
            'score_obtained' => $employeeMarkingScoreAdminDto->score_obtained,
            'score_out_of' => $employeeMarkingScoreAdminDto->score_out_of,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(EmployeeMarkingScore $employeeMarkingScore)
    {
        return tap($employeeMarkingScore)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        EmployeeMarkingScore::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
