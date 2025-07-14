<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\LabourAdminDto;
use Src\Yojana\Models\Labour;

class LabourAdminService
{
public function store(LabourAdminDto $labourAdminDto){
    return Labour::create([
        'title' => $labourAdminDto->title,
        'unit_id' => $labourAdminDto->unit_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Labour $labour, LabourAdminDto $labourAdminDto){
    return tap($labour)->update([
        'title' => $labourAdminDto->title,
        'unit_id' => $labourAdminDto->unit_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Labour $labour){
    return tap($labour)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Labour::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


