<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\CooperativeFarmerAdminDto;
use Src\GrantManagement\Models\CooperativeFarmer;

class CooperativeFarmerAdminService
{
public function store(CooperativeFarmerAdminDto $cooperativeFarmerAdminDto){
    return CooperativeFarmer::create([
        'cooperative_id' => $cooperativeFarmerAdminDto->cooperative_id,
        'farmer_id' => $cooperativeFarmerAdminDto->farmer_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CooperativeFarmer $cooperativeFarmer, CooperativeFarmerAdminDto $cooperativeFarmerAdminDto){
    return tap($cooperativeFarmer)->update([
        'cooperative_id' => $cooperativeFarmerAdminDto->cooperative_id,
        'farmer_id' => $cooperativeFarmerAdminDto->farmer_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CooperativeFarmer $cooperativeFarmer){
    return tap($cooperativeFarmer)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CooperativeFarmer::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


