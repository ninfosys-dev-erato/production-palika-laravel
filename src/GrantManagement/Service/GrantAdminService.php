<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantAdminDto;
use Src\GrantManagement\Models\Grant;

class GrantAdminService
{
public function store(GrantAdminDto $grantAdminDto){
    return Grant::create([
        'fiscal_year_id' => $grantAdminDto->fiscal_year_id,
        'grant_type_id' => $grantAdminDto->grant_type_id,
        'grant_office_id' => $grantAdminDto->grant_office_id,
        'grant_program_name' => $grantAdminDto->grant_program_name,
        'branch_id' => $grantAdminDto->branch_id,
        'grant_amount' => $grantAdminDto->grant_amount,
        'grant_for' => $grantAdminDto->grant_for,
        'main_activity' => $grantAdminDto->main_activity,
        'remarks' => $grantAdminDto->remarks,
        'user_id' => $grantAdminDto->user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Grant $grant, GrantAdminDto $grantAdminDto){
    return tap($grant)->update([
        'fiscal_year_id' => $grantAdminDto->fiscal_year_id,
        'grant_type_id' => $grantAdminDto->grant_type_id,
        'grant_office_id' => $grantAdminDto->grant_office_id,
        'grant_program_name' => $grantAdminDto->grant_program_name,
        'branch_id' => $grantAdminDto->branch_id,
        'grant_amount' => $grantAdminDto->grant_amount,
        'grant_for' => $grantAdminDto->grant_for,
        'main_activity' => $grantAdminDto->main_activity,
        'remarks' => $grantAdminDto->remarks,
        'user_id' => $grantAdminDto->user_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Grant $grant){
    return tap($grant)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Grant::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


