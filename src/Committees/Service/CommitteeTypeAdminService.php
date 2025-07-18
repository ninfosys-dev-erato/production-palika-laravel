<?php

namespace Src\Committees\Service;

use Illuminate\Support\Facades\Auth;
use Src\Committees\DTO\CommitteeTypeAdminDto;
use Src\Committees\Models\CommitteeType;

class CommitteeTypeAdminService
{
public function store(CommitteeTypeAdminDto $committeeTypeAdminDto){
    return CommitteeType::create([
        'name' => $committeeTypeAdminDto->name,
        'committee_no' => $committeeTypeAdminDto->committee_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CommitteeType $committeeType, CommitteeTypeAdminDto $committeeTypeAdminDto){
    return tap($committeeType)->update([
        'name' => $committeeTypeAdminDto->name,
        'committee_no' => $committeeTypeAdminDto->committee_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CommitteeType $committeeType){
    return tap($committeeType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CommitteeType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


