<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\TestList;

class TestListsExport implements FromCollection
{
    public $test_lists;

    public function __construct($test_lists) {
        $this->test_lists = $test_lists;
    }

    public function collection()
    {
        return TestList::select([
'title',
'type',
'is_for_agreement'
])
        ->whereIn('id', $this->test_lists)->get();
    }
}


