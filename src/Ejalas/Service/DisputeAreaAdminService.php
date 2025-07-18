<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\DisputeAreaAdminDto;
use Src\Ejalas\Models\DisputeArea;

class DisputeAreaAdminService
{
public function store(DisputeAreaAdminDto $disputeAreaAdminDto){
    return DisputeArea::create([
        'title' => $disputeAreaAdminDto->title,
        'title_en' => $disputeAreaAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(DisputeArea $disputeArea, DisputeAreaAdminDto $disputeAreaAdminDto){
    return tap($disputeArea)->update([
        'title' => $disputeAreaAdminDto->title,
        'title_en' => $disputeAreaAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(DisputeArea $disputeArea){
    return tap($disputeArea)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    DisputeArea::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


