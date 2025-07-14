<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementCost;
use Src\Yojana\Models\AgreementCostDetail;
use Src\Yojana\Models\PaymentTaxDeduction;

class PaymentTaxDeductionAdmindto
{
    public function __construct(
        public int $payment_id,
        public string $name,
        public string $evaluation_amount,
        public int $rate,
        public int $amount,
    ){}

    public static function fromLiveWireModel(PaymentTaxDeduction $paymentTaxDeduction): PaymentTaxDeductionAdmindto
    {
        return new self(
            payment_id : $paymentTaxDeduction->payment_id,
            name : $paymentTaxDeduction->name,
            evaluation_amount : $paymentTaxDeduction->evaluation_amount,
            rate : $paymentTaxDeduction->rate,
            amount : $paymentTaxDeduction->amount,
        );
    }

    public static function fromArrayData(array $data) : self
    {
        return new self(
            payment_id: $data['payment_id'],
            name: $data['name'],
            evaluation_amount: $data['evaluation_amount'],
            rate: $data['rate'],
            amount: $data['amount'],

        );
    }
}
