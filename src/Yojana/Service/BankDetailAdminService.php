<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BankDetailAdminDto;
use Src\Yojana\Models\BankDetail;

class BankDetailAdminService
{
public function store(BankDetailAdminDto $bankDetailAdminDto){
    return BankDetail::create([
        'title' => $bankDetailAdminDto->title,
        'branch' => $bankDetailAdminDto->branch,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BankDetail $bankDetail, BankDetailAdminDto $bankDetailAdminDto){
    return tap($bankDetail)->update([
        'title' => $bankDetailAdminDto->title,
        'branch' => $bankDetailAdminDto->branch,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BankDetail $bankDetail){
    return tap($bankDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BankDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


