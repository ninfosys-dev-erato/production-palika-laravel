<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\Installments;
use Src\Yojana\Models\AgreementCost;
use Src\Yojana\Models\AgreementCostDetail;
use Src\Yojana\Models\Payment;

class PaymentAdminDto
{
    public function __construct(
        public int $plan_id,
        public ?int $evaluation_id,
        public string $payment_date,
        public int $estimated_cost,
        public int $agreement_cost,
        public int $total_paid_amount,
        public ?Installments $installment,
        public ?int $evaluation_amount,
        public int $previous_advance,
        public int $current_advance,
        public int $previous_deposit,
        public int $current_deposit,
        public int $total_tax_deduction,
        public int $total_deduction,
        public int $paid_amount,
        public int $bill_amount,
    ){}

    public static function fromLiveWireModel(Payment $payment): PaymentAdminDto
    {
        return new self(
            plan_id : $payment->plan_id,
            evaluation_id : $payment->evaluation_id ?? null,
            payment_date : $payment->payment_date,
            estimated_cost : $payment->estimated_cost,
            agreement_cost : $payment->agreement_cost,
            total_paid_amount : $payment->total_paid_amount,
            installment : $payment->installment ?? null,
            evaluation_amount : $payment->evaluation_amount ?? null,
            previous_advance : $payment->previous_advance,
            current_advance : $payment->current_advance,
            previous_deposit : $payment->previous_deposit,
            current_deposit : $payment->current_deposit,
            total_tax_deduction : $payment->total_tax_deduction,
            total_deduction : $payment->total_deduction,
            paid_amount : $payment->paid_amount,
            bill_amount : $payment->bill_amount

        );
    }

    public static function fromArrayData(array $data): PaymentAdminDto
    {
        return new self(
            plan_id : $data['plan_id'],
            evaluation_id : $data['evaluation_id'] ?? null,
            payment_date : $data['payment_date'],
            estimated_cost : $data['estimated_cost'],
            agreement_cost : $data['agreement_cost'],
            total_paid_amount : $data['total_paid_amount'],
            installment : $data['installment'] ?? null,
            evaluation_amount : $data['evaluation_amount'] ?? null,
            previous_advance : $data['previous_advance'],
            current_advance : $data['current_advance'],
            previous_deposit : $data['previous_deposit'],
            current_deposit : $data['current_deposit'],
            total_tax_deduction : $data['total_tax_deduction'],
            total_deduction : $data['total_deduction'],
            paid_amount : $data['paid_amount'],
            bill_amount : $data['bill_amount']

        );
    }


}
