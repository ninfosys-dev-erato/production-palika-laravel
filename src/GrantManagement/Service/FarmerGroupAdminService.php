<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\FarmerGroupAdminDto;
use Src\GrantManagement\Models\FarmerGroup;

class FarmerGroupAdminService
{
public function store(FarmerGroupAdminDto $farmerGroupAdminDto){
    return FarmerGroup::create([
        'farmer_id' => $farmerGroupAdminDto->farmer_id,
        'group_id' => $farmerGroupAdminDto->group_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(FarmerGroup $farmerGroup, FarmerGroupAdminDto $farmerGroupAdminDto){
    return tap($farmerGroup)->update([
        'farmer_id' => $farmerGroupAdminDto->farmer_id,
        'group_id' => $farmerGroupAdminDto->group_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FarmerGroup $farmerGroup){
    return tap($farmerGroup)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FarmerGroup::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


