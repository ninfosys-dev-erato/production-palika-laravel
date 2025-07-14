<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\EvaluationCostDetailAdminDto;
use Src\Yojana\Models\EvaluationCostDetail;

class EvaluationCostDetailAdminService
{
    public function store(EvaluationCostDetailAdminDto $evaluationCostDetailAdminDto): EvaluationCostDetail
    {
        return EvaluationCostDetail::create([
            'evaluation_id' => $evaluationCostDetailAdminDto->evaluation_id,
            'activity_id' => $evaluationCostDetailAdminDto->activity_id,
            'unit' => $evaluationCostDetailAdminDto->unit,
            'agreement' => $evaluationCostDetailAdminDto->agreement,
            'before_this' => $evaluationCostDetailAdminDto->before_this,
            'up_to_date_amount' => $evaluationCostDetailAdminDto->up_to_date_amount,
            'current' => $evaluationCostDetailAdminDto->current,
            'rate' => $evaluationCostDetailAdminDto->rate,
            'assessment_amount' => $evaluationCostDetailAdminDto->assessment_amount,
            'vat_amount' => $evaluationCostDetailAdminDto->vat_amount,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(EvaluationCostDetail $evaluationCostDetail, EvaluationCostDetailAdminDto $evaluationCostDetailAdminDto): EvaluationCostDetail
    {
        return tap($evaluationCostDetail)->update([
            'evaluation_id' => $evaluationCostDetailAdminDto->evaluation_id,
            'activity_id' => $evaluationCostDetailAdminDto->activity_id,
            'unit' => $evaluationCostDetailAdminDto->unit,
            'agreement' => $evaluationCostDetailAdminDto->agreement,
            'before_this' => $evaluationCostDetailAdminDto->before_this,
            'up_to_date_amount' => $evaluationCostDetailAdminDto->up_to_date_amount,
            'current' => $evaluationCostDetailAdminDto->current,
            'rate' => $evaluationCostDetailAdminDto->rate,
            'assessment_amount' => $evaluationCostDetailAdminDto->assessment_amount,
            'vat_amount' => $evaluationCostDetailAdminDto->vat_amount,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(EvaluationCostDetail $evaluationCostDetail): EvaluationCostDetail
    {
        return tap($evaluationCostDetail)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            EvaluationCostDetail::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


