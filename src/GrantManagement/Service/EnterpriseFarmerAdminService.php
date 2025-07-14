<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\EnterpriseFarmerAdminDto;
use Src\GrantManagement\Models\EnterpriseFarmer;

class EnterpriseFarmerAdminService
{
public function store(EnterpriseFarmerAdminDto $enterpriseFarmerAdminDto){
    return EnterpriseFarmer::create([
        'enterprise_id' => $enterpriseFarmerAdminDto->enterprise_id,
        'farmer_id' => $enterpriseFarmerAdminDto->farmer_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(EnterpriseFarmer $enterpriseFarmer, EnterpriseFarmerAdminDto $enterpriseFarmerAdminDto){
    return tap($enterpriseFarmer)->update([
        'enterprise_id' => $enterpriseFarmerAdminDto->enterprise_id,
        'farmer_id' => $enterpriseFarmerAdminDto->farmer_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(EnterpriseFarmer $enterpriseFarmer){
    return tap($enterpriseFarmer)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    EnterpriseFarmer::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


