<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ActivityAdminDto;
use Src\Yojana\Models\Activity;

class ActivityAdminService
{
public function store(ActivityAdminDto $activityAdminDto){
    return Activity::create([
        'title' => $activityAdminDto->title,
        'group_id' => $activityAdminDto->group_id,
        'code' => $activityAdminDto->code,
        'ref_code' => $activityAdminDto->ref_code,
        'unit_id' => $activityAdminDto->unit_id,
        'qty_for' => $activityAdminDto->qty_for,
        'will_be_in_use' => $activityAdminDto->will_be_in_use,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Activity $activity, ActivityAdminDto $activityAdminDto){
    return tap($activity)->update([
        'title' => $activityAdminDto->title,
        'group_id' => $activityAdminDto->group_id,
        'code' => $activityAdminDto->code,
        'ref_code' => $activityAdminDto->ref_code,
        'unit_id' => $activityAdminDto->unit_id,
        'qty_for' => $activityAdminDto->qty_for,
        'will_be_in_use' => $activityAdminDto->will_be_in_use,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Activity $activity){
    return tap($activity)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Activity::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


