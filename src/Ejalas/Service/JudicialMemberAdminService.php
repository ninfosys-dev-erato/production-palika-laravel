<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\JudicialMemberAdminDto;
use Src\Ejalas\Models\JudicialMember;

class JudicialMemberAdminService
{
public function store(JudicialMemberAdminDto $judicialMemberAdminDto){
    return JudicialMember::create([
        'title' => $judicialMemberAdminDto->title,
        'member_position' => $judicialMemberAdminDto->member_position,
        'elected_position' => $judicialMemberAdminDto->elected_position,
        'status' => $judicialMemberAdminDto->status,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(JudicialMember $judicialMember, JudicialMemberAdminDto $judicialMemberAdminDto){
    return tap($judicialMember)->update([
        'title' => $judicialMemberAdminDto->title,
        'member_position' => $judicialMemberAdminDto->member_position,
        'elected_position' => $judicialMemberAdminDto->elected_position,
        'status' => $judicialMemberAdminDto->status,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(JudicialMember $judicialMember){
    return tap($judicialMember)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    JudicialMember::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


