<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\Models\Activity;
use Src\TaskTracking\DTO\ActivityAdminDto;

class ActivityAdminService
{
    /**
     * Store a new activity record.
     *
     * @param ActivityAdminDto $ActivityAdminDto
     * @return \Src\TaskTracking\Models\Activity
     */
    public function store(ActivityAdminDto $ActivityAdminDto)
    {
        return Activity::create([
            'task_id' => $ActivityAdminDto->task_id,
            'action' => $ActivityAdminDto->action,
            'user_type' => $ActivityAdminDto->user_type,
            'user_id' => $ActivityAdminDto->user_id,
            'description' => $ActivityAdminDto->description,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    /**
     * Update an existing activity record.
     *
     * @param \Src\TaskTracking\Models\Activity $activity
     * @param ActivityAdminDto $ActivityAdminDto
     * @return \Src\TaskTracking\Models\Activity
     */
    public function update(Activity $activity, ActivityAdminDto $ActivityAdminDto)
    {
        return tap($activity)->update([
            'action' => $ActivityAdminDto->action,
            'description' => $ActivityAdminDto->description,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    /**
     * Soft delete an activity record.
     *
     * @param \Src\TaskTracking\Models\Activity $activity
     * @return \Src\TaskTracking\Models\Activity
     */
    public function delete(Activity $activity)
    {
        return tap($activity)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    /**
     * Soft delete multiple activity records.
     *
     * @param array $ids
     * @return void
     */
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));

        Activity::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
