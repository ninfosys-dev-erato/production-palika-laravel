<?php

namespace Src\FileTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FileRecordNotifiees\Models\FileRecordNotifiee;

class FileRecordNotifieesExport implements FromCollection
{
    public $file_record_notifiees;

    public function __construct($file_record_notifiees) {
        $this->file_record_notifiees = $file_record_notifiees;
    }

    public function collection()
    {
        return FileRecordNotifiee::select([
'file_record_log_id',
'notifiable_type',
'notifiable_id'
])
        ->whereIn('id', $this->file_record_notifiees)->get();
    }
}


