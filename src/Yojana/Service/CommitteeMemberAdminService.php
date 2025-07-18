<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CommitteeMemberAdminDto;
use Src\Yojana\Models\CommitteeMember;

class CommitteeMemberAdminService
{
public function store(CommitteeMemberAdminDto $committeeMemberAdminDto){
    return CommitteeMember::create([
        'committee_id' => $committeeMemberAdminDto->committee_id,
        'name' => $committeeMemberAdminDto->name,
        'designation' => $committeeMemberAdminDto->designation,
        'phone' => $committeeMemberAdminDto->phone,
        'photo' => $committeeMemberAdminDto->photo,
        'email' => $committeeMemberAdminDto->email,
        'province_id' => $committeeMemberAdminDto->province_id,
        'district_id' => $committeeMemberAdminDto->district_id,
        'local_body_id' => $committeeMemberAdminDto->local_body_id,
        'ward_no' => $committeeMemberAdminDto->ward_no,
        'tole' => $committeeMemberAdminDto->tole,
        'position' => $committeeMemberAdminDto->position,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CommitteeMember $committeeMember, CommitteeMemberAdminDto $committeeMemberAdminDto){
    return tap($committeeMember)->update([
        'committee_id' => $committeeMemberAdminDto->committee_id,
        'name' => $committeeMemberAdminDto->name,
        'designation' => $committeeMemberAdminDto->designation,
        'phone' => $committeeMemberAdminDto->phone,
        'photo' => $committeeMemberAdminDto->photo,
        'email' => $committeeMemberAdminDto->email,
        'province_id' => $committeeMemberAdminDto->province_id,
        'district_id' => $committeeMemberAdminDto->district_id,
        'local_body_id' => $committeeMemberAdminDto->local_body_id,
        'ward_no' => $committeeMemberAdminDto->ward_no,
        'tole' => $committeeMemberAdminDto->tole,
        'position' => $committeeMemberAdminDto->position,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CommitteeMember $committeeMember){
    return tap($committeeMember)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CommitteeMember::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


