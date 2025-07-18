<?php

namespace Src\LocalBodies\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\LocalBodies\Models\LocalBody;

class LocalBodiesExport implements FromCollection
{
    public $local_bodies;

    public function __construct($local_bodies) {
        $this->local_bodies = $local_bodies;
    }

    public function collection()
    {
        return LocalBody::select([
'district_id',
'title',
'title_en',
'wards'
])
        ->whereIn('id', $this->local_bodies)->get();
    }
}


