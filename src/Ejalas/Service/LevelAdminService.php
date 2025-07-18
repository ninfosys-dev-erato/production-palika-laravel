<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\LevelAdminDto;
use Src\Ejalas\Models\Level;

class LevelAdminService
{
public function store(LevelAdminDto $levelAdminDto){
    return Level::create([
        'title' => $levelAdminDto->title,
        'title_en' => $levelAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Level $level, LevelAdminDto $levelAdminDto){
    return tap($level)->update([
        'title' => $levelAdminDto->title,
        'title_en' => $levelAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Level $level){
    return tap($level)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Level::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


