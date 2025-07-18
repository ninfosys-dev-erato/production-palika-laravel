<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\TargetAdminDto;
use Src\Yojana\Models\Target;

class TargetAdminService
{
public function store(TargetAdminDto $targetAdminDto){
    return Target::create([
        'title' => $targetAdminDto->title,
        'code' => $targetAdminDto->code,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Target $target, TargetAdminDto $targetAdminDto){
    return tap($target)->update([
        'title' => $targetAdminDto->title,
        'code' => $targetAdminDto->code,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Target $target){
    return tap($target)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Target::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


