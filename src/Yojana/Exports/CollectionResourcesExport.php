<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\CollectionResource;

class CollectionResourcesExport implements FromCollection
{
    public $collection_resources;

    public function __construct($collection_resources) {
        $this->collection_resources = $collection_resources;
    }

    public function collection()
    {
        return CollectionResource::select([
'model_type',
'model_id',
'collectable',
'type',
'quantity',
'rate_type',
'rate'
])
        ->whereIn('id', $this->collection_resources)->get();
    }
}


