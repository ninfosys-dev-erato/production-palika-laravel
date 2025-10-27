<?php

namespace Src\Yojana\Service;

use App\Facades\PdfFacade;
use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AdvancePaymentAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Traits\YojanaTemplate;

class AdvancePaymentAdminService
{
    use YojanaTemplate;
public function store(AdvancePaymentAdminDto $advancePaymentAdminDto){
    return AdvancePayment::create([
        'plan_id' => $advancePaymentAdminDto->plan_id,
        'installment' => $advancePaymentAdminDto->installment,
        'date' => $advancePaymentAdminDto->date,
        'clearance_date' => $advancePaymentAdminDto->clearance_date,
        'advance_deposit_number' => $advancePaymentAdminDto->advance_deposit_number,
        'paid_amount' => $advancePaymentAdminDto->paid_amount,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(AdvancePayment $advancePayment, AdvancePaymentAdminDto $advancePaymentAdminDto){
    return tap($advancePayment)->update([
        'plan_id' => $advancePaymentAdminDto->plan_id,
        'installment' => $advancePaymentAdminDto->installment,
        'date' => $advancePaymentAdminDto->date,
        'clearance_date' => $advancePaymentAdminDto->clearance_date,
        'advance_deposit_number' => $advancePaymentAdminDto->advance_deposit_number,
        'paid_amount' => $advancePaymentAdminDto->paid_amount,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(AdvancePayment $advancePayment){
    return tap($advancePayment)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    AdvancePayment::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
    public function getWorkOrder($id)
    {

        $advancePayment = AdvancePayment::find($id);

        $plan = $advancePayment->plan->load('costEstimation','agreement','StartFiscalYear','implementationAgency.consumerCommittee', 'implementationAgency.application','implementationAgency.organization');

        $plan->setRelation('advancePayments', $advancePayment);
        $workOrderService = new WorkOrderAdminService();
        return $workOrderService->workOrderLetter(LetterTypes::AdvancePayment , $plan);
    }
    
    /**
     * Get or create a WorkOrder for the given advance payment and letter type.
     *
     * @param int $id
     * @param LetterTypes $type
     * @return \Src\Yojana\Models\WorkOrder|null
     */
    public function getWorkOrderByType($id, LetterTypes $type)
    {
        $advancePayment = AdvancePayment::find($id);

        $plan = $advancePayment->plan->load('costEstimation','agreement','StartFiscalYear','implementationAgency.consumerCommittee', 'implementationAgency.application','implementationAgency.organization');

        $plan->setRelation('advancePayments', $advancePayment);
        $workOrderService = new WorkOrderAdminService();
        return $workOrderService->workOrderLetter($type, $plan);
    }
}


