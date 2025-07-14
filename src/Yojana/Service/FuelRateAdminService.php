<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\FuelRateAdminDto;
use Src\Yojana\Models\FuelRate;

class FuelRateAdminService
{
public function store(FuelRateAdminDto $fuelRateAdminDto){
    return FuelRate::create([
        'fuel_id' => $fuelRateAdminDto->fuel_id,
        'rate' => $fuelRateAdminDto->rate,
        'has_included_vat' => $fuelRateAdminDto->has_included_vat,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(FuelRate $fuelRate, FuelRateAdminDto $fuelRateAdminDto){
    return tap($fuelRate)->update([
        'fuel_id' => $fuelRateAdminDto->fuel_id,
        'rate' => $fuelRateAdminDto->rate,
        'has_included_vat' => $fuelRateAdminDto->has_included_vat,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FuelRate $fuelRate){
    return tap($fuelRate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FuelRate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


