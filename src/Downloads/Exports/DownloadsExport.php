<?php

namespace Src\Downloads\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Downloads\Models\Download;

class DownloadsExport implements FromCollection
{
    public $downloads;

    public function __construct($downloads) {
        $this->downloads = $downloads;
    }

    public function collection()
    {
        return Download::select([
'title',
'title_en',
'files',
'status',
'order'
])
        ->whereIn('id', $this->downloads)->get();
    }
}


