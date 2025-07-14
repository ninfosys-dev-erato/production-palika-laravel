<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementBeneficiaryAdminDto;
use Src\Yojana\Models\AgreementBeneficiary;

class AgreementBeneficiaryAdminService
{
public function store(AgreementBeneficiaryAdminDto $agreementBeneficiaryAdminDto){
    return AgreementBeneficiary::create([
        'agreement_id' => $agreementBeneficiaryAdminDto->agreement_id,
        'beneficiary_id' => $agreementBeneficiaryAdminDto->beneficiary_id,
        'total_count' => $agreementBeneficiaryAdminDto->total_count,
        'men_count' => $agreementBeneficiaryAdminDto->men_count,
        'women_count' => $agreementBeneficiaryAdminDto->women_count,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(AgreementBeneficiary $agreementBeneficiary, AgreementBeneficiaryAdminDto $agreementBeneficiaryAdminDto){
    return tap($agreementBeneficiary)->update([
        'agreement_id' => $agreementBeneficiaryAdminDto->agreement_id,
        'beneficiary_id' => $agreementBeneficiaryAdminDto->beneficiary_id,
        'total_count' => $agreementBeneficiaryAdminDto->total_count,
        'men_count' => $agreementBeneficiaryAdminDto->men_count,
        'women_count' => $agreementBeneficiaryAdminDto->women_count,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(AgreementBeneficiary $agreementBeneficiary){
    return tap($agreementBeneficiary)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    AgreementBeneficiary::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


