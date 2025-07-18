<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\StoreyAdminDto;
use Src\Ebps\Models\Storey;

class StoreyAdminService
{
public function store(StoreyAdminDto $storeyAdminDto){
    return Storey::create([
        'title' => $storeyAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Storey $storey, StoreyAdminDto $storeyAdminDto){
    return tap($storey)->update([
        'title' => $storeyAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Storey $storey){
    return tap($storey)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Storey::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


