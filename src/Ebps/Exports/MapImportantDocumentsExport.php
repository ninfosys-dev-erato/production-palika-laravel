<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\MapImportantDocument;

class MapImportantDocumentsExport implements FromCollection
{
    public $map_important_documents;

    public function __construct($map_important_documents) {
        $this->map_important_documents = $map_important_documents;
    }

    public function collection()
    {
        return MapImportantDocument::select([
'ebps_document_id',
'can_be_null',
'map_important_document_type',
'accepted_file_type',
'needs_approval',
'position'
])
        ->whereIn('id', $this->map_important_documents)->get();
    }
}


