<?php

namespace Src\ActivityLogs\Service;

use Illuminate\Support\Facades\Auth;
use Src\ActivityLogs\DTO\ActivityLogAdminDto;
use Src\ActivityLogs\Models\ActivityLog;

class ActivityLogAdminService
{
public function store(ActivityLogAdminDto $activityLogAdminDto){
    return ActivityLog::create([
        'log_name' => $activityLogAdminDto->log_name,
        'description' => $activityLogAdminDto->description,
        'subject_type' => $activityLogAdminDto->subject_type,
        'event' => $activityLogAdminDto->event,
        'subject_id' => $activityLogAdminDto->subject_id,
        'causer_type' => $activityLogAdminDto->causer_type,
        'causer_id' => $activityLogAdminDto->causer_id,
        'properties' => $activityLogAdminDto->properties,
        'batch_uuid' => $activityLogAdminDto->batch_uuid,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ActivityLog $activityLog, ActivityLogAdminDto $activityLogAdminDto){
    return tap($activityLog)->update([
        'log_name' => $activityLogAdminDto->log_name,
        'description' => $activityLogAdminDto->description,
        'subject_type' => $activityLogAdminDto->subject_type,
        'event' => $activityLogAdminDto->event,
        'subject_id' => $activityLogAdminDto->subject_id,
        'causer_type' => $activityLogAdminDto->causer_type,
        'causer_id' => $activityLogAdminDto->causer_id,
        'properties' => $activityLogAdminDto->properties,
        'batch_uuid' => $activityLogAdminDto->batch_uuid,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ActivityLog $activityLog){
    return tap($activityLog)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ActivityLog::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


