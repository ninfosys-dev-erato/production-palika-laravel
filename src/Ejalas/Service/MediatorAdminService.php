<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\MediatorAdminDto;
use Src\Ejalas\Models\Mediator;

class MediatorAdminService
{
public function store(MediatorAdminDto $mediatorAdminDto){
    return Mediator::create([
        'fiscal_year_id' => $mediatorAdminDto->fiscal_year_id,
        'listed_no' => $mediatorAdminDto->listed_no,
        'mediator_name' => $mediatorAdminDto->mediator_name,
        'mediator_address' => $mediatorAdminDto->mediator_address,
        'ward_id' => $mediatorAdminDto->ward_id,
        'training_detail' => $mediatorAdminDto->training_detail,
        'mediator_phone_no' => $mediatorAdminDto->mediator_phone_no,
        'mediator_email' => $mediatorAdminDto->mediator_email,
        'municipal_approval_date' => $mediatorAdminDto->municipal_approval_date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Mediator $mediator, MediatorAdminDto $mediatorAdminDto){
    return tap($mediator)->update([
        'fiscal_year_id' => $mediatorAdminDto->fiscal_year_id,
        'listed_no' => $mediatorAdminDto->listed_no,
        'mediator_name' => $mediatorAdminDto->mediator_name,
        'mediator_address' => $mediatorAdminDto->mediator_address,
        'ward_id' => $mediatorAdminDto->ward_id,
        'training_detail' => $mediatorAdminDto->training_detail,
        'mediator_phone_no' => $mediatorAdminDto->mediator_phone_no,
        'mediator_email' => $mediatorAdminDto->mediator_email,
        'municipal_approval_date' => $mediatorAdminDto->municipal_approval_date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Mediator $mediator){
    return tap($mediator)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Mediator::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


