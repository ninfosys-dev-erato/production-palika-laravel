<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ConsumerCommitteeMemberAdminDto;
use Src\Yojana\Models\ConsumerCommitteeMember;

class ConsumerCommitteeMemberAdminService
{
public function store(ConsumerCommitteeMemberAdminDto $consumerCommitteeMemberAdminDto){
    return ConsumerCommitteeMember::create([
        'consumer_committee_id' => $consumerCommitteeMemberAdminDto->consumer_committee_id,
        'citizenship_number' => $consumerCommitteeMemberAdminDto->citizenship_number,
        'name' => $consumerCommitteeMemberAdminDto->name,
        'gender' => $consumerCommitteeMemberAdminDto->gender,
        'father_name' => $consumerCommitteeMemberAdminDto->father_name,
        'husband_name' => $consumerCommitteeMemberAdminDto->husband_name,
        'grandfather_name' => $consumerCommitteeMemberAdminDto->grandfather_name,
        'father_in_law_name' => $consumerCommitteeMemberAdminDto->father_in_law_name,
        'is_monitoring_committee' => $consumerCommitteeMemberAdminDto->is_monitoring_committee,
        'designation' => $consumerCommitteeMemberAdminDto->designation,
        'address' => $consumerCommitteeMemberAdminDto->address,
        'mobile_number' => $consumerCommitteeMemberAdminDto->mobile_number,
        'is_account_holder' => $consumerCommitteeMemberAdminDto->is_account_holder,
        'citizenship_upload' => $consumerCommitteeMemberAdminDto->citizenship_upload,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ConsumerCommitteeMember $consumerCommitteeMember, ConsumerCommitteeMemberAdminDto $consumerCommitteeMemberAdminDto){
    return tap($consumerCommitteeMember)->update([
        'consumer_committee_id' => $consumerCommitteeMemberAdminDto->consumer_committee_id,
        'citizenship_number' => $consumerCommitteeMemberAdminDto->citizenship_number,
        'name' => $consumerCommitteeMemberAdminDto->name,
        'gender' => $consumerCommitteeMemberAdminDto->gender,
        'father_name' => $consumerCommitteeMemberAdminDto->father_name,
        'husband_name' => $consumerCommitteeMemberAdminDto->husband_name,
        'grandfather_name' => $consumerCommitteeMemberAdminDto->grandfather_name,
        'father_in_law_name' => $consumerCommitteeMemberAdminDto->father_in_law_name,
        'is_monitoring_committee' => $consumerCommitteeMemberAdminDto->is_monitoring_committee,
        'designation' => $consumerCommitteeMemberAdminDto->designation,
        'address' => $consumerCommitteeMemberAdminDto->address,
        'mobile_number' => $consumerCommitteeMemberAdminDto->mobile_number,
        'is_account_holder' => $consumerCommitteeMemberAdminDto->is_account_holder,
        'citizenship_upload' => $consumerCommitteeMemberAdminDto->citizenship_upload,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ConsumerCommitteeMember $consumerCommitteeMember){
    return tap($consumerCommitteeMember)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ConsumerCommitteeMember::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


