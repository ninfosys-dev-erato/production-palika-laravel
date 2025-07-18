<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\Document;

class DocumentsExport implements FromCollection
{
    public $documents;

    public function __construct($documents) {
        $this->documents = $documents;
    }

    public function collection()
    {
        return Document::select([
'title'
])
        ->whereIn('id', $this->documents)->get();
    }
}


