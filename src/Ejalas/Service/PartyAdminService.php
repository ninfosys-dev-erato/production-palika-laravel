<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\PartyAdminDto;
use Src\Ejalas\Models\Party;

class PartyAdminService
{
    public function store(PartyAdminDto $partyAdminDto)
    {
        return Party::create([
            'name' => $partyAdminDto->name,
            'age' => $partyAdminDto->age,
            'phone_no' => $partyAdminDto->phone_no,
            'citizenship_no' => $partyAdminDto->citizenship_no,
            'gender' => $partyAdminDto->gender,
            'grandfather_name' => $partyAdminDto->grandfather_name,
            // 'father_name' => $partyAdminDto->father_name,
            'spouse_name' => $partyAdminDto->spouse_name,
            'permanent_province_id' => $partyAdminDto->permanent_province_id,
            'permanent_district_id' => $partyAdminDto->permanent_district_id,
            'permanent_local_body_id' => $partyAdminDto->permanent_local_body_id,
            'permanent_ward_id' => $partyAdminDto->permanent_ward_id,
            'permanent_tole' => $partyAdminDto->permanent_tole,
            'temporary_province_id' => $partyAdminDto->temporary_province_id,
            'temporary_district_id' => $partyAdminDto->temporary_district_id,
            'temporary_local_body_id' => $partyAdminDto->temporary_local_body_id,
            'temporary_ward_id' => $partyAdminDto->temporary_ward_id,
            'temporary_tole' => $partyAdminDto->temporary_tole,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Party $party, PartyAdminDto $partyAdminDto)
    {
        return tap($party)->update([
            'name' => $partyAdminDto->name,
            'age' => $partyAdminDto->age,
            'phone_no' => $partyAdminDto->phone_no,
            'citizenship_no' => $partyAdminDto->citizenship_no,
            'gender' => $partyAdminDto->gender,
            'grandfather_name' => $partyAdminDto->grandfather_name,
            'father_name' => $partyAdminDto->father_name,
            'spouse_name' => $partyAdminDto->spouse_name,
            'permanent_province_id' => $partyAdminDto->permanent_province_id,
            'permanent_district_id' => $partyAdminDto->permanent_district_id,
            'permanent_local_body_id' => $partyAdminDto->permanent_local_body_id,
            'permanent_ward_id' => $partyAdminDto->permanent_ward_id,
            'permanent_tole' => $partyAdminDto->permanent_tole,
            'temporary_province_id' => $partyAdminDto->temporary_province_id,
            'temporary_district_id' => $partyAdminDto->temporary_district_id,
            'temporary_local_body_id' => $partyAdminDto->temporary_local_body_id,
            'temporary_ward_id' => $partyAdminDto->temporary_ward_id,
            'temporary_tole' => $partyAdminDto->temporary_tole,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Party $party)
    {
        return tap($party)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Party::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
