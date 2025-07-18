<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\JudicialCommitteeAdminDto;
use Src\Ejalas\Models\JudicialCommittee;

class JudicialCommitteeAdminService
{
public function store(JudicialCommitteeAdminDto $judicialCommitteeAdminDto){
    return JudicialCommittee::create(attributes: [
        'ommittees_title' => $judicialCommitteeAdminDto->committees_title,
        'short_title' => $judicialCommitteeAdminDto->short_title,
        'title' => $judicialCommitteeAdminDto->title,
        'subtitle' => $judicialCommitteeAdminDto->subtitle,
        'formation_date' => $judicialCommitteeAdminDto->formation_date,
        'phone_no' => $judicialCommitteeAdminDto->phone_no,
        'email' => $judicialCommitteeAdminDto->email,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(JudicialCommittee $judicialCommittee, JudicialCommitteeAdminDto $judicialCommitteeAdminDto){
    return tap($judicialCommittee)->update([
        'committees_title' => $judicialCommitteeAdminDto->committees_title,
        'short_title' => $judicialCommitteeAdminDto->short_title,
        'title' => $judicialCommitteeAdminDto->title,
        'subtitle' => $judicialCommitteeAdminDto->subtitle,
        'formation_date' => $judicialCommitteeAdminDto->formation_date,
        'phone_no' => $judicialCommitteeAdminDto->phone_no,
        'email' => $judicialCommitteeAdminDto->email,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(JudicialCommittee $judicialCommittee){
    return tap($judicialCommittee)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    JudicialCommittee::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


