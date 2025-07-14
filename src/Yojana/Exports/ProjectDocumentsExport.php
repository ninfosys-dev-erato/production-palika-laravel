<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectDocument;

class ProjectDocumentsExport implements FromCollection
{
    public $project_documents;

    public function __construct($project_documents) {
        $this->project_documents = $project_documents;
    }

    public function collection()
    {
        return ProjectDocument::select([
'project_id',
'document_name',
'data'
])
        ->whereIn('id', $this->project_documents)->get();
    }
}


