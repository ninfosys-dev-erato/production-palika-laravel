<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\LegalDocument;

class LegalDocumentsExport implements FromCollection
{
    public $legal_documents;

    public function __construct($legal_documents) {
        $this->legal_documents = $legal_documents;
    }

    public function collection()
    {
        return LegalDocument::select([
'complaint_registration_id',
'party_side',
'party_name',
'document_writer_name',
'document_date',
'document_details'
])
        ->whereIn('id', $this->legal_documents)->get();
    }
}


