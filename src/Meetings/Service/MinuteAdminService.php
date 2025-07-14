<?php

namespace Src\Meetings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Meetings\DTO\MinuteAdminDto;
use Src\Meetings\Models\Minute;

class MinuteAdminService
{
public function store(MinuteAdminDto $minuteAdminDto){
    return Minute::create([
        'meeting_id' => $minuteAdminDto->meeting_id,
        'description' => $minuteAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Minute $minute, MinuteAdminDto $minuteAdminDto){
    return tap($minute)->update([
        'description' => $minuteAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Minute $minute){
    return tap($minute)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Minute::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}