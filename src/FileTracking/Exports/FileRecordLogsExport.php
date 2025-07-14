<?php

namespace Src\FileTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FileTracking\Models\FileRecordLog;

class FileRecordLogsExport implements FromCollection
{
    public $file_record_logs;

    public function __construct($file_record_logs) {
        $this->file_record_logs = $file_record_logs;
    }

    public function collection()
    {
        return FileRecordLog::select([
'reg_no',
'status',
'notes',
'handler_type',
'handler_id'
])
        ->whereIn('id', $this->file_record_logs)->get();
    }
}


