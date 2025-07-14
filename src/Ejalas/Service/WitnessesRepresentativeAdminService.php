<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\WitnessesRepresentativeAdminDto;
use Src\Ejalas\Models\WitnessesRepresentative;

class WitnessesRepresentativeAdminService
{
public function store(WitnessesRepresentativeAdminDto $witnessesRepresentativeAdminDto){
    return WitnessesRepresentative::create([
        'complaint_registration_id' => $witnessesRepresentativeAdminDto->complaint_registration_id,
        'name' => $witnessesRepresentativeAdminDto->name,
        'address' => $witnessesRepresentativeAdminDto->address,
        'is_first_party' => $witnessesRepresentativeAdminDto->is_first_party,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(WitnessesRepresentative $witnessesRepresentative, WitnessesRepresentativeAdminDto $witnessesRepresentativeAdminDto){
    return tap($witnessesRepresentative)->update([
        'complaint_registration_id' => $witnessesRepresentativeAdminDto->complaint_registration_id,
        'name' => $witnessesRepresentativeAdminDto->name,
        'address' => $witnessesRepresentativeAdminDto->address,
        'is_first_party' => $witnessesRepresentativeAdminDto->is_first_party,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(WitnessesRepresentative $witnessesRepresentative){
    return tap($witnessesRepresentative)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    WitnessesRepresentative::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


