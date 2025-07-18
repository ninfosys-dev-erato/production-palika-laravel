<?php

namespace Src\EmergencyContacts\Service;

use Illuminate\Support\Facades\Auth;
use Src\EmergencyContacts\DTO\EmergencyContactAdminDto;
use Src\EmergencyContacts\Models\EmergencyContact;

class EmergencyContactAdminService
{
public function store(EmergencyContactAdminDto $emergencyContactAdminDto){
    return EmergencyContact::create([
        'group' => $emergencyContactAdminDto->group,
        'parent_id' => $emergencyContactAdminDto->parent_id,
        'service_name' => $emergencyContactAdminDto->service_name,
        'service_name_ne' => $emergencyContactAdminDto->service_name_ne,
        'icon' => $emergencyContactAdminDto->icon,
        'contact_person' => $emergencyContactAdminDto->contact_person,
        'contact_person_ne' => $emergencyContactAdminDto->contact_person_ne,
        'address' => $emergencyContactAdminDto->address,
        'address_ne' => $emergencyContactAdminDto->address_ne,
        'contact_numbers' => $emergencyContactAdminDto->contact_numbers,
        'site_map' => $emergencyContactAdminDto->site_map,
        'content' => $emergencyContactAdminDto->content,
        'content_ne' => $emergencyContactAdminDto->content_ne,
        'website_url' => $emergencyContactAdminDto->website_url,
        'facebook_url' => $emergencyContactAdminDto->facebook_url,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(EmergencyContact $emergencyContact, EmergencyContactAdminDto $emergencyContactAdminDto){
    return tap($emergencyContact)->update([
        'group' => $emergencyContactAdminDto->group,
        'parent_id' => $emergencyContactAdminDto->parent_id,
        'service_name' => $emergencyContactAdminDto->service_name,
        'service_name_ne' => $emergencyContactAdminDto->service_name_ne,
        'icon' => $emergencyContactAdminDto->icon,
        'contact_person' => $emergencyContactAdminDto->contact_person,
        'contact_person_ne' => $emergencyContactAdminDto->contact_person_ne,
        'address' => $emergencyContactAdminDto->address,
        'address_ne' => $emergencyContactAdminDto->address_ne,
        'contact_numbers' => $emergencyContactAdminDto->contact_numbers,
        'site_map' => $emergencyContactAdminDto->site_map,
        'content' => $emergencyContactAdminDto->content,
        'content_ne' => $emergencyContactAdminDto->content_ne,
        'website_url' => $emergencyContactAdminDto->website_url,
        'facebook_url' => $emergencyContactAdminDto->facebook_url,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(EmergencyContact $emergencyContact){
    return tap($emergencyContact)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    EmergencyContact::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


