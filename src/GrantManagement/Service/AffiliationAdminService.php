<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\AffiliationAdminDto;
use Src\GrantManagement\Models\Affiliation;

class AffiliationAdminService
{
public function store(AffiliationAdminDto $affiliationAdminDto){
    return Affiliation::create([
        'title' => $affiliationAdminDto->title,
        'title_en' => $affiliationAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Affiliation $affiliation, AffiliationAdminDto $affiliationAdminDto){
    return tap($affiliation)->update([
        'title' => $affiliationAdminDto->title,
        'title_en' => $affiliationAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Affiliation $affiliation){
    return tap($affiliation)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Affiliation::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


