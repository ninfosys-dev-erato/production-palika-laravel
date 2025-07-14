<?php

namespace Src\ActivityLogs\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\ActivityLogs\Models\ActivityLog;

class ActivityLogsExport implements FromCollection
{
    public $activity_logs;

    public function __construct($activity_logs) {
        $this->activity_logs = $activity_logs;
    }

    public function collection()
    {
        return ActivityLog::select([
'log_name',
'description',
'subject_type',
'event',
'subject_id',
'causer_type',
'causer_id',
'properties',
'batch_uuid'
])
        ->whereIn('id', $this->activity_logs)->get();
    }
}


