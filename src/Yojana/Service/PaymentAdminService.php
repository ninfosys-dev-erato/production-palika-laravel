<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PaymentAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\Payment;

class PaymentAdminService
{
    public function store(PaymentAdminDto $paymentDto): Payment
    {
        return Payment::create([
            'plan_id' => $paymentDto->plan_id,
            'evaluation_id' => $paymentDto->evaluation_id,
            'payment_date' => $paymentDto->payment_date,
            'estimated_cost' => $paymentDto->estimated_cost,
            'agreement_cost' => $paymentDto->agreement_cost,
            'total_paid_amount' => $paymentDto->total_paid_amount,
            'installment' => $paymentDto->installment,
            'evaluation_amount' => $paymentDto->evaluation_amount,
            'previous_advance' => $paymentDto->previous_advance,
            'current_advance' => $paymentDto->current_advance,
            'previous_deposit' => $paymentDto->previous_deposit,
            'current_deposit' => $paymentDto->current_deposit,
            'total_tax_deduction' => $paymentDto->total_tax_deduction,
            'total_deduction' => $paymentDto->total_deduction,
            'paid_amount' => $paymentDto->paid_amount,
            'bill_amount' => $paymentDto->bill_amount,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(Payment $payment, PaymentAdminDto $paymentDto): Payment
    {
        return tap($payment)->update([
            'plan_id' => $paymentDto->plan_id,
            'evaluation_id' => $paymentDto->evaluation_id,
            'payment_date' => $paymentDto->payment_date,
            'estimated_cost' => $paymentDto->estimated_cost,
            'agreement_cost' => $paymentDto->agreement_cost,
            'total_paid_amount' => $paymentDto->total_paid_amount,
            'installment' => $paymentDto->installment,
            'evaluation_amount' => $paymentDto->evaluation_amount,
            'previous_advance' => $paymentDto->previous_advance,
            'current_advance' => $paymentDto->current_advance,
            'previous_deposit' => $paymentDto->previous_deposit,
            'current_deposit' => $paymentDto->current_deposit,
            'total_tax_deduction' => $paymentDto->total_tax_deduction,
            'total_deduction' => $paymentDto->total_deduction,
            'paid_amount' => $paymentDto->paid_amount,
            'bill_amount' => $paymentDto->bill_amount,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(Payment $payment): Payment
    {
        return tap($payment)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            Payment::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getWorkOrder($id, $letterType)
    {
        $payment = Payment::find($id);
        $plan = $payment->plan;
        $plan->load('costEstimation.costDetails.sourceType','costEstimation.configDetails.configuration','agreement.agreementCost.agreementCostDetails','StartFiscalYear','implementationAgency.consumerCommittee', 'implementationAgency.application','implementationAgency.organization','advancePayments', 'evaluations','payments.taxDeductions.configuration');
        $workOrderService = new WorkOrderAdminService();
        return $workOrderService->workOrderLetter($letterType , $plan);
    }

    public function printPaymentLetter($id) {
        return $this->getWorkOrder($id, LetterTypes::Payment);
    }

    public function printPaymentRecommendation($id) {
        return $this->getWorkOrder($id, LetterTypes::PaymentRecommendationLetter);
    }

    public function printPlanHandoverLetter($id) {
        return $this->getWorkOrder($id, LetterTypes::PlanHandoverLetter);
    }
}


