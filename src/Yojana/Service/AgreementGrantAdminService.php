<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementGrantAdminDto;
use Src\Yojana\Models\AgreementGrant;

class AgreementGrantAdminService
{
public function store(AgreementGrantAdminDto $agreementGrantAdminDto){
    return AgreementGrant::create([
        'agreement_id' => $agreementGrantAdminDto->agreement_id,
        'source_type_id' => $agreementGrantAdminDto->source_type_id,
        'material_name' => $agreementGrantAdminDto->material_name,
        'unit' => $agreementGrantAdminDto->unit,
        'amount' => $agreementGrantAdminDto->amount,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(AgreementGrant $agreementGrant, AgreementGrantAdminDto $agreementGrantAdminDto){
    return tap($agreementGrant)->update([
        'agreement_id' => $agreementGrantAdminDto->agreement_id,
        'source_type_id' => $agreementGrantAdminDto->source_type_id,
        'material_name' => $agreementGrantAdminDto->material_name,
        'unit' => $agreementGrantAdminDto->unit,
        'amount' => $agreementGrantAdminDto->amount,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(AgreementGrant $agreementGrant){
    return tap($agreementGrant)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    AgreementGrant::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


