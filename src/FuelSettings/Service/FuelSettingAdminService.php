<?php

namespace Src\FuelSettings\Service;

use Illuminate\Support\Facades\Auth;
use Src\FuelSettings\DTO\FuelSettingAdminDto;
use Src\FuelSettings\Models\FuelSetting;

class FuelSettingAdminService
{
public function store(FuelSettingAdminDto $fuelSettingAdminDto){
    return FuelSetting::create([
        'acceptor_id' => $fuelSettingAdminDto->acceptor_id,
        'reviewer_id' => $fuelSettingAdminDto->reviewer_id,
        'expiry_days' => $fuelSettingAdminDto->expiry_days,
        'ward_no' => $fuelSettingAdminDto->ward_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(FuelSetting $fuelSetting, FuelSettingAdminDto $fuelSettingAdminDto){
    return tap($fuelSetting)->update([
        'acceptor_id' => $fuelSettingAdminDto->acceptor_id,
        'reviewer_id' => $fuelSettingAdminDto->reviewer_id,
        'expiry_days' => $fuelSettingAdminDto->expiry_days,
        'ward_no' => $fuelSettingAdminDto->ward_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FuelSetting $fuelSetting){
    return tap($fuelSetting)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FuelSetting::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


