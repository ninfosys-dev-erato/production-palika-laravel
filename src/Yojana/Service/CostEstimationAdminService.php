<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CostEstimationAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\CostEstimation;

class CostEstimationAdminService
{
    public function store(CostEstimationAdminDto $costEstimationDto){
        return CostEstimation::updateOrCreate([
            'plan_id' => $costEstimationDto->plan_id],[
            'date' => $costEstimationDto->date,
            'total_cost' => $costEstimationDto->total_cost,
            'is_revised' => $costEstimationDto->is_revised,
            'revision_no' => $costEstimationDto->revision_no,
            'status' => $costEstimationDto->status,
            'rate_analysis_document' => $costEstimationDto->rate_analysis_document,
            'cost_estimation_document' => $costEstimationDto->cost_estimation_document,
            'initial_photo' => $costEstimationDto->initial_photo,
            'document_upload' => $costEstimationDto->document_upload,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CostEstimation $costEstimation, CostEstimationAdminDto $costEstimationDto){
        return tap($costEstimation)->update([
            'plan_id' => $costEstimationDto->plan_id,
            'date' => $costEstimationDto->date,
            'total_cost' => $costEstimationDto->total_cost,
            'is_revised' => $costEstimationDto->is_revised,
            'revision_no' => $costEstimationDto->revision_no,
            'revision_date' => $costEstimationDto->revision_date ,
            'status' => $costEstimationDto->status,
            'rate_analysis_document' => $costEstimationDto->rate_analysis_document,
            'cost_estimation_document' => $costEstimationDto->cost_estimation_document,
            'initial_photo' => $costEstimationDto->initial_photo,
            'document_upload' => $costEstimationDto->document_upload,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CostEstimation $costEstimation){
        return tap($costEstimation)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CostEstimation::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function getWorkOrder($plan)
    {
        $plan = $plan->load('budgetSources.sourceType', 'budgetSources.budgetHead', 'budgetSources.expenseHead', 'budgetSources.budgetDetail');
        $workOrderService = new WorkOrderAdminService();
        return $workOrderService->workOrderLetter(LetterTypes::ProgramApprovalAndInformationLetter , $plan);
    }
}


