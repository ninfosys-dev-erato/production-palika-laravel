<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CommitteeAdminDto;
use Src\Yojana\Models\Committee;

class CommitteeAdminService
{
public function store(CommitteeAdminDto $committeeAdminDto){
    return Committee::create([
        'committee_type_id' => $committeeAdminDto->committee_type_id,
        'committee_name' => $committeeAdminDto->committee_name,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Committee $committee, CommitteeAdminDto $committeeAdminDto){
    return tap($committee)->update([
        'committee_type_id' => $committeeAdminDto->committee_type_id,
        'committee_name' => $committeeAdminDto->committee_name,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
    public function delete(Committee $committee)
    {
        return tap($committee)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Committee::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }
}


