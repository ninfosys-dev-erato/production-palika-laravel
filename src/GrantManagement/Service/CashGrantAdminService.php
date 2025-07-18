<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\CashGrantAdminDto;
use Src\GrantManagement\Models\CashGrant;

class CashGrantAdminService
{
public function store(CashGrantAdminDto $cashGrantAdminDto){
    return CashGrant::create([
        'name' => $cashGrantAdminDto->name,
        'address' => $cashGrantAdminDto->address,
        'age' => $cashGrantAdminDto->age,
        'contact' => $cashGrantAdminDto->contact,
        'citizenship_no' => $cashGrantAdminDto->citizenship_no,
        'father_name' => $cashGrantAdminDto->father_name,
        'grandfather_name' => $cashGrantAdminDto->grandfather_name,
        'helplessness_type_id' => $cashGrantAdminDto->helplessness_type_id,
        'cash' => $cashGrantAdminDto->cash,
        'file' => $cashGrantAdminDto->file,
        'remark' => $cashGrantAdminDto->remark,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CashGrant $cashGrant, CashGrantAdminDto $cashGrantAdminDto){
    return tap($cashGrant)->update([
        'name' => $cashGrantAdminDto->name,
        'address' => $cashGrantAdminDto->address,
        'age' => $cashGrantAdminDto->age,
        'contact' => $cashGrantAdminDto->contact,
        'citizenship_no' => $cashGrantAdminDto->citizenship_no,
        'father_name' => $cashGrantAdminDto->father_name,
        'grandfather_name' => $cashGrantAdminDto->grandfather_name,
        'helplessness_type_id' => $cashGrantAdminDto->helplessness_type_id,
        'cash' => $cashGrantAdminDto->cash,
        'file' => $cashGrantAdminDto->file,
        'remark' => $cashGrantAdminDto->remark,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CashGrant $cashGrant){
    return tap($cashGrant)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CashGrant::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


