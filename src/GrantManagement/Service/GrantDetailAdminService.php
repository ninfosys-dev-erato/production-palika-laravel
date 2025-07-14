<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantDetailAdminDto;
use Src\GrantManagement\Models\GrantDetail;

class GrantDetailAdminService
{
public function store(GrantDetailAdminDto $grantDetailAdminDto){
    return GrantDetail::create([
        'grant_id' => $grantDetailAdminDto->grant_id,
        'grant_for' => $grantDetailAdminDto->grant_for,
        'model_type' => $grantDetailAdminDto->model_type,
        'model_id' => $grantDetailAdminDto->model_id,
        'personal_investment' => $grantDetailAdminDto->personal_investment,
        'is_old' => $grantDetailAdminDto->is_old,
        'prev_fiscal_year_id' => $grantDetailAdminDto->prev_fiscal_year_id,
        'investment_amount' => $grantDetailAdminDto->investment_amount,
        'remarks' => $grantDetailAdminDto->remarks,
        'local_body_id' => $grantDetailAdminDto->local_body_id,
        'ward_no' => $grantDetailAdminDto->ward_no,
        'village' => $grantDetailAdminDto->village,
        'tole' => $grantDetailAdminDto->tole,
        'plot_no' => $grantDetailAdminDto->plot_no,
        'contact_person' => $grantDetailAdminDto->contact_person,
        'contact' => $grantDetailAdminDto->contact,
        'user_id' => $grantDetailAdminDto->user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(GrantDetail $grantDetail, GrantDetailAdminDto $grantDetailAdminDto){
    return tap($grantDetail)->update([
        'grant_id' => $grantDetailAdminDto->grant_id,
        'grant_for' => $grantDetailAdminDto->grant_for,
        'model_type' => $grantDetailAdminDto->model_type,
        'model_id' => $grantDetailAdminDto->model_id,
        'personal_investment' => $grantDetailAdminDto->personal_investment,
        'is_old' => $grantDetailAdminDto->is_old,
        'prev_fiscal_year_id' => $grantDetailAdminDto->prev_fiscal_year_id,
        'investment_amount' => $grantDetailAdminDto->investment_amount,
        'remarks' => $grantDetailAdminDto->remarks,
        'local_body_id' => $grantDetailAdminDto->local_body_id,
        'ward_no' => $grantDetailAdminDto->ward_no,
        'village' => $grantDetailAdminDto->village,
        'tole' => $grantDetailAdminDto->tole,
        'plot_no' => $grantDetailAdminDto->plot_no,
        'contact_person' => $grantDetailAdminDto->contact_person,
        'contact' => $grantDetailAdminDto->contact,
        'user_id' => $grantDetailAdminDto->user_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(GrantDetail $grantDetail){
    return tap($grantDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    GrantDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


