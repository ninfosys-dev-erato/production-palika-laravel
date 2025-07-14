<?php

namespace Src\DigitalBoard\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DigitalBoard\Models\Notice;

class NoticesExport implements FromCollection
{
    public $notices;

    public function __construct($notices)
    {
        $this->notices = $notices;
    }

    public function collection()
    {
        return Notice::select([
            'title',
            'date',
            'can_show_on_admin'
        ])
            ->whereIn('id', $this->notices)->get();
    }
}
