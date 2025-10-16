<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ImplementationAgencyAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\ImplementationAgency;
use Src\Yojana\Models\Plan;

class ImplementationAgencyAdminService
{
public function store(ImplementationAgencyAdminDto $implementationAgencyAdminDto){
    return ImplementationAgency::updateOrCreate([
        'plan_id' => $implementationAgencyAdminDto->plan_id],[
        'consumer_committee_id' => $implementationAgencyAdminDto->consumer_committee_id,
        'organization_id' => $implementationAgencyAdminDto->organization_id,
        'application_id' => $implementationAgencyAdminDto->application_id,
        'model' => $implementationAgencyAdminDto->model,
        'comment' => $implementationAgencyAdminDto->comment,
        'agreement_application' => $implementationAgencyAdminDto->agreement_application,
        'agreement_recommendation_letter' => $implementationAgencyAdminDto->agreement_recommendation_letter,
        'deposit_voucher' => $implementationAgencyAdminDto->deposit_voucher,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ImplementationAgency $implementationAgency, ImplementationAgencyAdminDto $implementationAgencyAdminDto){
    return tap($implementationAgency)->update([
        'plan_id' => $implementationAgencyAdminDto->plan_id,
        'consumer_committee_id' => $implementationAgencyAdminDto->consumer_committee_id,
        'organization_id' => $implementationAgencyAdminDto->organization_id,
        'application_id' => $implementationAgencyAdminDto->application_id,
        'model' => $implementationAgencyAdminDto->model,
        'comment' => $implementationAgencyAdminDto->comment,
        'agreement_application' => $implementationAgencyAdminDto->agreement_application,
        'agreement_recommendation_letter' => $implementationAgencyAdminDto->agreement_recommendation_letter,
        'deposit_voucher' => $implementationAgencyAdminDto->deposit_voucher,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ImplementationAgency $implementationAgency){
    return tap($implementationAgency)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ImplementationAgency::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

    public function getWorkOrder($id)
    {
        $implementationAgency = ImplementationAgency::find($id);
        $plan  = Plan::find($implementationAgency->plan_id);
        $plan->load('agreement','costEstimation.costDetails.sourceType');

        $committeeCost = $plan->costEstimation->costDetails->where('costSource.code' ,'2' )->first();
        $plan->setRelation('committeeCost', $committeeCost->cost_amount ?? 0);

        $workOrderService = new WorkOrderAdminService();
        return $workOrderService->workOrderLetter(LetterTypes::AgreementInstruction , $plan);
    }
}


