<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementSignatureDetailAdminDto;
use Src\Yojana\Models\AgreementSignatureDetail;

class AgreementSignatureDetailAdminService
{
public function store(AgreementSignatureDetailAdminDto $agreementSignatureDetailAdminDto){
    return AgreementSignatureDetail::create([
        'agreement_id' => $agreementSignatureDetailAdminDto->agreement_id,
        'signature_party' => $agreementSignatureDetailAdminDto->signature_party ?? 0,
        'name' => $agreementSignatureDetailAdminDto->name,
        'position' => $agreementSignatureDetailAdminDto->position,
        'address' => $agreementSignatureDetailAdminDto->address,
        'contact_number' => $agreementSignatureDetailAdminDto->contact_number,
        'date' => $agreementSignatureDetailAdminDto->date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(AgreementSignatureDetail $agreementSignatureDetail, AgreementSignatureDetailAdminDto $agreementSignatureDetailAdminDto){
    return tap($agreementSignatureDetail)->update([
        'agreement_id' => $agreementSignatureDetailAdminDto->agreement_id,
        'signature_party' => $agreementSignatureDetailAdminDto->signature_party ?? 0,
        'name' => $agreementSignatureDetailAdminDto->name,
        'position' => $agreementSignatureDetailAdminDto->position,
        'address' => $agreementSignatureDetailAdminDto->address,
        'contact_number' => $agreementSignatureDetailAdminDto->contact_number,
        'date' => $agreementSignatureDetailAdminDto->date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(AgreementSignatureDetail $agreementSignatureDetail){
    return tap($agreementSignatureDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    AgreementSignatureDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


