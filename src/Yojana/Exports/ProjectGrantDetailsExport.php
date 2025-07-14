<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectGrantDetail;

class ProjectGrantDetailsExport implements FromCollection
{
    public $project_grant_details;

    public function __construct($project_grant_details) {
        $this->project_grant_details = $project_grant_details;
    }

    public function collection()
    {
        return ProjectGrantDetail::select([
'project_id',
'grant_source',
'asset_name',
'quantity',
'asset_unit'
])
        ->whereIn('id', $this->project_grant_details)->get();
    }
}


