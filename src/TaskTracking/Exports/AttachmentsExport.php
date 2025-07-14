<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Attachment;

class AttachmentsExport implements FromCollection
{
    public $attachments;

    public function __construct($attachments) {
        $this->attachments = $attachments;
    }

    public function collection()
    {
        return Attachment::select([
'file',
'attachable_type',
'attachable_id'
])
        ->whereIn('id', $this->attachments)->get();
    }
}


