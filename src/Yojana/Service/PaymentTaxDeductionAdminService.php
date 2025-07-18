<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PaymentTaxDeductionAdmindto;
use Src\Yojana\Models\PaymentTaxDeduction;

class PaymentTaxDeductionAdminService
{
    public function store(PaymentTaxDeductionAdmindto $paymentTaxDeductionDto): PaymentTaxDeduction
    {
        return PaymentTaxDeduction::create([
            'payment_id' => $paymentTaxDeductionDto->payment_id,
            'name' => $paymentTaxDeductionDto->name,
            'evaluation_amount' => $paymentTaxDeductionDto->evaluation_amount,
            'rate' => $paymentTaxDeductionDto->rate,
            'amount' => $paymentTaxDeductionDto->amount,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(PaymentTaxDeduction $paymentTaxDeduction, PaymentTaxDeductionAdmindto $paymentTaxDeductionDto): PaymentTaxDeduction
    {
        return tap($paymentTaxDeduction)->update([
            'payment_id' => $paymentTaxDeductionDto->payment_id,
            'name' => $paymentTaxDeductionDto->name,
            'evaluation_amount' => $paymentTaxDeductionDto->evaluation_amount,
            'rate' => $paymentTaxDeductionDto->rate,
            'amount' => $paymentTaxDeductionDto->amount,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(PaymentTaxDeduction $paymentTaxDeduction): PaymentTaxDeduction
    {
        return tap($paymentTaxDeduction)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            PaymentTaxDeduction::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


