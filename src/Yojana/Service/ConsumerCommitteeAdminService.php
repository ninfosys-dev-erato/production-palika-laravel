<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ConsumerCommitteeAdminDto;
use Src\Yojana\Models\ConsumerCommittee;

class ConsumerCommitteeAdminService
{
public function store(ConsumerCommitteeAdminDto $consumerCommitteeAdminDto){
    return ConsumerCommittee::create([
        'committee_type_id' => $consumerCommitteeAdminDto->committee_type_id,
        'registration_number' => $consumerCommitteeAdminDto->registration_number,
        'formation_date' => $consumerCommitteeAdminDto->formation_date,
        'name' => $consumerCommitteeAdminDto->name,
        'ward_id' => $consumerCommitteeAdminDto->ward_id,
        'address' => $consumerCommitteeAdminDto->address,
        'creating_body' => $consumerCommitteeAdminDto->creating_body,
        'bank_id' => $consumerCommitteeAdminDto->bank_id,
        'account_number' => $consumerCommitteeAdminDto->account_number,
        'formation_minute' => $consumerCommitteeAdminDto->formation_minute,
        'number_of_attendees' => $consumerCommitteeAdminDto->number_of_attendees,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ConsumerCommittee $consumerCommittee, ConsumerCommitteeAdminDto $consumerCommitteeAdminDto){
    return tap($consumerCommittee)->update([
        'committee_type_id' => $consumerCommitteeAdminDto->committee_type_id,
        'registration_number' => $consumerCommitteeAdminDto->registration_number,
        'formation_date' => $consumerCommitteeAdminDto->formation_date,
        'name' => $consumerCommitteeAdminDto->name,
        'ward_id' => $consumerCommitteeAdminDto->ward_id,
        'address' => $consumerCommitteeAdminDto->address,
        'creating_body' => $consumerCommitteeAdminDto->creating_body,
        'bank_id' => $consumerCommitteeAdminDto->bank_id,
        'account_number' => $consumerCommitteeAdminDto->account_number,
        'formation_minute' => $consumerCommitteeAdminDto->formation_minute,
        'number_of_attendees' => $consumerCommitteeAdminDto->number_of_attendees,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ConsumerCommittee $consumerCommittee){
    return tap($consumerCommittee)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ConsumerCommittee::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


