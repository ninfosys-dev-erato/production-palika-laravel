<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ItemType;

class ItemTypesExport implements FromCollection
{
    public $item_types;

    public function __construct($item_types) {
        $this->item_types = $item_types;
    }

    public function collection()
    {
        return ItemType::select([
'title',
'code',
'group'
])
        ->whereIn('id', $this->item_types)->get();
    }
}


