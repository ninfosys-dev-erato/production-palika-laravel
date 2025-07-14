<?php

namespace Src\FileTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FileRecords\Models\FileRecord;

class FileRecordsExport implements FromCollection
{
    public $file_records;

    public function __construct($file_records) {
        $this->file_records = $file_records;
    }

    public function collection()
    {
        return FileRecord::select([
'reg_no',
'subject_type',
'subject_id'
])
        ->whereIn('id', $this->file_records)->get();
    }
}


