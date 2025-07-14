<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\FarmerAdminDto;
use Src\GrantManagement\Models\Farmer;

class FarmerAdminService
{
    public function store(FarmerAdminDto $farmerAdminDto)
    {
        return Farmer::create([
            'unique_id' => $farmerAdminDto->unique_id,
            'first_name' => $farmerAdminDto->first_name,
            'middle_name' => $farmerAdminDto->middle_name,
            'last_name' => $farmerAdminDto->last_name,
            'photo' => $farmerAdminDto->photo,
            'gender' => $farmerAdminDto->gender,
            'marital_status' => $farmerAdminDto->marital_status,
            'spouse_name' => $farmerAdminDto->spouse_name,
            'father_name' => $farmerAdminDto->father_name,
            'grandfather_name' => $farmerAdminDto->grandfather_name,
            'citizenship_no' => $farmerAdminDto->citizenship_no,
            'farmer_id_card_no' => $farmerAdminDto->farmer_id_card_no,
            'national_id_card_no' => $farmerAdminDto->national_id_card_no,
            'phone_no' => $farmerAdminDto->phone_no,
            'province_id' => $farmerAdminDto->province_id,
            'district_id' => $farmerAdminDto->district_id,
            'local_body_id' => $farmerAdminDto->local_body_id,
            'farmer_ids' => $farmerAdminDto->farmer_ids,
            'relationships' => $farmerAdminDto->relationships,
            'ward_no' => $farmerAdminDto->ward_no,
            'village' => $farmerAdminDto->village,
            'tole' => $farmerAdminDto->tole,
            'user_id' => $farmerAdminDto->user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Farmer $farmer, FarmerAdminDto $farmerAdminDto)
    {
        return tap($farmer)->update([
            'unique_id' => $farmerAdminDto->unique_id,
            'first_name' => $farmerAdminDto->first_name,
            'middle_name' => $farmerAdminDto->middle_name,
            'last_name' => $farmerAdminDto->last_name,
            'photo' => $farmerAdminDto->photo,
            'gender' => $farmerAdminDto->gender,
            'marital_status' => $farmerAdminDto->marital_status,
            'spouse_name' => $farmerAdminDto->spouse_name,
            'father_name' => $farmerAdminDto->father_name,
            'grandfather_name' => $farmerAdminDto->grandfather_name,
            'citizenship_no' => $farmerAdminDto->citizenship_no,
            'farmer_id_card_no' => $farmerAdminDto->farmer_id_card_no,
            'national_id_card_no' => $farmerAdminDto->national_id_card_no,
            'phone_no' => $farmerAdminDto->phone_no,
            'province_id' => $farmerAdminDto->province_id,
            'district_id' => $farmerAdminDto->district_id,
            'local_body_id' => $farmerAdminDto->local_body_id,
            'ward_no' => $farmerAdminDto->ward_no,
            'village' => $farmerAdminDto->village,
            'tole' => $farmerAdminDto->tole,
            'user_id' => $farmerAdminDto->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Farmer $farmer)
    {
        return tap($farmer)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Farmer::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


