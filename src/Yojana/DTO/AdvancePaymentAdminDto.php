<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\Installments;
use Src\Yojana\Models\AdvancePayment;

class AdvancePaymentAdminDto
{
    public function __construct(
        public string $plan_id,
        public Installments $installment,
        public string $date,
        public string $clearance_date,
        public string $advance_deposit_number,
        public string $paid_amount
    ) {}

    public static function fromLiveWireModel(AdvancePayment $advancePayment): AdvancePaymentAdminDto
    {
        return new self(
            plan_id: $advancePayment->plan_id,
            installment: $advancePayment->installment,
            date: $advancePayment->date,
            clearance_date: $advancePayment->clearance_date,
            advance_deposit_number: $advancePayment->advance_deposit_number,
            paid_amount: $advancePayment->paid_amount
        );
    }
}
