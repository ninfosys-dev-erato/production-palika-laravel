<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\EvaluationAdminDto;
use Src\Yojana\Models\Evaluation;

class EvaluationAdminService
{
    public function store(EvaluationAdminDto $evaluationAdminDto)
    {
        return Evaluation::create([
            'plan_id' => $evaluationAdminDto->plan_id,
            'evaluation_date' => $evaluationAdminDto->evaluation_date,
            'completion_date' => $evaluationAdminDto->completion_date,
            'installment_no' => $evaluationAdminDto->installment_no,
            'up_to_date_amount' => $evaluationAdminDto->up_to_date_amount,
            'assessment_amount' => $evaluationAdminDto->assessment_amount,
            'evaluation_amount' => $evaluationAdminDto->evaluation_amount,
            'total_vat' => $evaluationAdminDto->total_vat,
            'is_implemented' => $evaluationAdminDto->is_implemented,
            'is_budget_utilized' => $evaluationAdminDto->is_budget_utilized,
            'is_quality_maintained' => $evaluationAdminDto->is_quality_maintained,
            'is_reached' => $evaluationAdminDto->is_reached,
            'is_tested' => $evaluationAdminDto->is_tested,
            'testing_date' => $evaluationAdminDto->testing_date,
            'attendance_number' => $evaluationAdminDto->attendance_number,
            'evaluation_no' => $evaluationAdminDto->evaluation_no,
            'ward_recommendation_document' => $evaluationAdminDto->ward_recommendation_document,
            'technical_evaluation_document' => $evaluationAdminDto->technical_evaluation_document,
            'committee_report' => $evaluationAdminDto->committee_report,
            'attendance_report' => $evaluationAdminDto->attendance_report,
            'construction_progress_photo' => $evaluationAdminDto->construction_progress_photo,
            'work_completion_report' => $evaluationAdminDto->work_completion_report,
            'expense_report' => $evaluationAdminDto->expense_report,
            'other_document' => $evaluationAdminDto->other_document,
            'is_vatable' => $evaluationAdminDto->is_vatable,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Evaluation $evaluation, EvaluationAdminDto $evaluationAdminDto)
    {
        return tap($evaluation)->update([
            'plan_id' => $evaluationAdminDto->plan_id,
            'evaluation_date' => $evaluationAdminDto->evaluation_date,
            'completion_date' => $evaluationAdminDto->completion_date,
            'installment_no' => $evaluationAdminDto->installment_no,
            'up_to_date_amount' => $evaluationAdminDto->up_to_date_amount,
            'assessment_amount' => $evaluationAdminDto->assessment_amount,
            'evaluation_amount' => $evaluationAdminDto->evaluation_amount,
            'total_vat' => $evaluationAdminDto->total_vat,
            'is_implemented' => $evaluationAdminDto->is_implemented,
            'is_budget_utilized' => $evaluationAdminDto->is_budget_utilized,
            'is_quality_maintained' => $evaluationAdminDto->is_quality_maintained,
            'is_reached' => $evaluationAdminDto->is_reached,
            'is_tested' => $evaluationAdminDto->is_tested,
            'testing_date' => $evaluationAdminDto->testing_date,
            'attendance_number' => $evaluationAdminDto->attendance_number,
            'evaluation_no' => $evaluationAdminDto->evaluation_no,
            'ward_recommendation_document' => $evaluationAdminDto->ward_recommendation_document,
            'technical_evaluation_document' => $evaluationAdminDto->technical_evaluation_document,
            'committee_report' => $evaluationAdminDto->committee_report,
            'attendance_report' => $evaluationAdminDto->attendance_report,
            'construction_progress_photo' => $evaluationAdminDto->construction_progress_photo,
            'work_completion_report' => $evaluationAdminDto->work_completion_report,
            'expense_report' => $evaluationAdminDto->expense_report,
            'other_document' => $evaluationAdminDto->other_document,
            'is_vatable' => $evaluationAdminDto->is_vatable,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Evaluation $evaluation)
    {
        return tap($evaluation)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Evaluation::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
