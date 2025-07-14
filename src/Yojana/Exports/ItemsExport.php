<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Item;

class ItemsExport implements FromCollection
{
    public $items;

    public function __construct($items) {
        $this->items = $items;
    }

    public function collection()
    {
        return Item::select([
'title',
'type_id',
'code',
'unit_id',
'remarks'
])
        ->whereIn('id', $this->items)->get();
    }
}


