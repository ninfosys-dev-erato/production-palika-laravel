<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementWitnessDetailAdminDto;
use Src\Yojana\Models\AgreementWitnessDetail;

class AgreementWitnessDetailAdminService
{
    public function store(AgreementWitnessDetailAdminDto $dto){
        return AgreementWitnessDetail::create([
            'agreement_id' => $dto->agreement_id,
            'employee_id' => $dto->employee_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()?->id,
        ]);
    }

    public function update(AgreementWitnessDetail $model, AgreementWitnessDetailAdminDto $dto){
        return tap($model)->update([
            'agreement_id' => $dto->agreement_id,
            'employee_id' => $dto->employee_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()?->id,
        ]);
    }

    public function delete(AgreementWitnessDetail $model){
        return tap($model)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()?->id,
        ]);
    }

    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        AgreementWitnessDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()?->id,
        ]);
    }
}
