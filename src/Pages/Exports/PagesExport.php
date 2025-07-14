<?php

namespace Src\Pages\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Pages\Models\Page;

class PagesExport implements FromCollection
{
    public $pages;

    public function __construct($pages) {
        $this->pages = $pages;
    }

    public function collection()
    {
        return Page::select([
'slug',
'title',
'content'
])
        ->whereIn('id', $this->pages)->get();
    }
}


