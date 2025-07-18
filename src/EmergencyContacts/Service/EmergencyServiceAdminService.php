<?php

namespace Src\EmergencyContacts\Service;

use Illuminate\Support\Facades\Auth;
use Src\EmergencyContacts\DTO\EmergencyServiceAdminDto;
use Src\EmergencyContacts\Models\EmergencyService;

class EmergencyServiceAdminService
{
public function store(EmergencyServiceAdminDto $emergencyServiceAdminDto){
    return emergencyService::create([
        'emergency_id' => $emergencyServiceAdminDto->emergency_id,
        'contact_person' => $emergencyServiceAdminDto->contact_person,
        'contact_person_ne' => $emergencyServiceAdminDto->contact_person_ne,
        'address' => $emergencyServiceAdminDto->address,
        'address_ne' => $emergencyServiceAdminDto->address_ne,
        'contact_numbers' => $emergencyServiceAdminDto->contact_numbers,
        'site_map' => $emergencyServiceAdminDto->site_map,
        'website_url' => $emergencyServiceAdminDto->website_url,
        'facebook_url' => $emergencyServiceAdminDto->facebook_url,
        'image' => $emergencyServiceAdminDto->image ?? null,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(EmergencyService $emergencyService, EmergencyServiceAdminDto $emergencyServiceAdminDto){
    return tap($emergencyService)->update([
        'contact_person' => $emergencyServiceAdminDto->contact_person,
        'contact_person_ne' => $emergencyServiceAdminDto->contact_person_ne,
        'address' => $emergencyServiceAdminDto->address,
        'address_ne' => $emergencyServiceAdminDto->address_ne,
        'contact_numbers' => $emergencyServiceAdminDto->contact_numbers,
        'site_map' => $emergencyServiceAdminDto->site_map,
        'website_url' => $emergencyServiceAdminDto->website_url,
        'facebook_url' => $emergencyServiceAdminDto->facebook_url,
        'image' => $emergencyServiceAdminDto->image ?? null,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(EmergencyService $emergencyService){
    return tap($emergencyService)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
     EmergencyService::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


