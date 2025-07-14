<?php

namespace Src\DigitalBoard\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DigitalBoard\Models\PopUp;

class PopUpsExport implements FromCollection
{
    public $pop_ups;

    public function __construct($pop_ups)
    {
        $this->pop_ups = $pop_ups;
    }

    public function collection()
    {
        return PopUp::select([
            'title',
            'photo',
            'is_active',
            'display_duration',
            'iteration_duration',
            'can_show_on_admin'
        ])
            ->whereIn('id', $this->pop_ups)->get();
    }
}
