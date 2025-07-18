<?php

namespace Src\Meetings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Meetings\DTO\InvitedMemberAdminDto;
use Src\Meetings\Models\InvitedMember;

class InvitedMemberAdminService
{
public function store(InvitedMemberAdminDto $invitedMemberAdminDto){
    return InvitedMember::create([
        'name' => $invitedMemberAdminDto->name,
        'meeting_id' => $invitedMemberAdminDto->meeting_id,
        'designation' => $invitedMemberAdminDto->designation,
        'phone' => $invitedMemberAdminDto->phone,
        'email' => $invitedMemberAdminDto->email,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(InvitedMember $invitedMember, InvitedMemberAdminDto $invitedMemberAdminDto){
    return tap($invitedMember)->update([
        'name' => $invitedMemberAdminDto->name,
        'meeting_id' => $invitedMemberAdminDto->meeting_id,
        'designation' => $invitedMemberAdminDto->designation,
        'phone' => $invitedMemberAdminDto->phone,
        'email' => $invitedMemberAdminDto->email,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(InvitedMember $invitedMember){
    return tap($invitedMember)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    InvitedMember::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}