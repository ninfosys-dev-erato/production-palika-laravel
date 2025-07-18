<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ConsumerCommitteeOfficialAdminDto;
use Src\Yojana\Models\ConsumerCommitteeOfficial;

class ConsumerCommitteeOfficialAdminService
{
public function store(ConsumerCommitteeOfficialAdminDto $consumerCommitteeOfficialAdminDto){
    return ConsumerCommitteeOfficial::create([
        'consumer_committee_id' => $consumerCommitteeOfficialAdminDto->consumer_committee_id,
        'post' => $consumerCommitteeOfficialAdminDto->post,
        'name' => $consumerCommitteeOfficialAdminDto->name,
        'father_name' => $consumerCommitteeOfficialAdminDto->father_name,
        'grandfather_name' => $consumerCommitteeOfficialAdminDto->grandfather_name,
        'address' => $consumerCommitteeOfficialAdminDto->address,
        'gender' => $consumerCommitteeOfficialAdminDto->gender,
        'phone' => $consumerCommitteeOfficialAdminDto->phone,
        'citizenship_no' => $consumerCommitteeOfficialAdminDto->citizenship_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ConsumerCommitteeOfficial $consumerCommitteeOfficial, ConsumerCommitteeOfficialAdminDto $consumerCommitteeOfficialAdminDto){
    return tap($consumerCommitteeOfficial)->update([
        'consumer_committee_id' => $consumerCommitteeOfficialAdminDto->consumer_committee_id,
        'post' => $consumerCommitteeOfficialAdminDto->post,
        'name' => $consumerCommitteeOfficialAdminDto->name,
        'father_name' => $consumerCommitteeOfficialAdminDto->father_name,
        'grandfather_name' => $consumerCommitteeOfficialAdminDto->grandfather_name,
        'address' => $consumerCommitteeOfficialAdminDto->address,
        'gender' => $consumerCommitteeOfficialAdminDto->gender,
        'phone' => $consumerCommitteeOfficialAdminDto->phone,
        'citizenship_no' => $consumerCommitteeOfficialAdminDto->citizenship_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ConsumerCommitteeOfficial $consumerCommitteeOfficial){
    return tap($consumerCommitteeOfficial)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ConsumerCommitteeOfficial::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


