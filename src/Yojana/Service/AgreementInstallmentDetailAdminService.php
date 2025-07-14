<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementInstallmentDetailsAdminDto;
use Src\Yojana\Models\AgreementInstallmentDetails;

class AgreementInstallmentDetailAdminService
{
    public function store(AgreementInstallmentDetailsAdminDto $agreementInstallmentDetailsDto){
        return AgreementInstallmentDetails::create([
            'agreement_id' => $agreementInstallmentDetailsDto->agreement_id,
            'installment_number' => $agreementInstallmentDetailsDto->installment_number,
            'release_date' => $agreementInstallmentDetailsDto->release_date,
            'cash_amount' => $agreementInstallmentDetailsDto->cash_amount,
            'goods_amount' => $agreementInstallmentDetailsDto->goods_amount,
            'percentage' => $agreementInstallmentDetailsDto->percentage,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(AgreementInstallmentDetails $agreementInstallmentDetails, AgreementInstallmentDetailsAdminDto $agreementInstallmentDetailsDto){
        return tap($agreementInstallmentDetails)->update([
            'agreement_id' => $agreementInstallmentDetailsDto->agreement_id,
            'installment_number' => $agreementInstallmentDetailsDto->installment_number,
            'release_date' => $agreementInstallmentDetailsDto->release_date,
            'cash_amount' => $agreementInstallmentDetailsDto->cash_amount,
            'goods_amount' => $agreementInstallmentDetailsDto->goods_amount,
            'percentage' => $agreementInstallmentDetailsDto->percentage,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(AgreementInstallmentDetails $agreementInstallmentDetails){
        return tap($agreementInstallmentDetails)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        AgreementInstallmentDetails::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


