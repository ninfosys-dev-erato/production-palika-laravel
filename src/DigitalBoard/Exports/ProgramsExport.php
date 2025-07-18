<?php

namespace Src\DigitalBoard\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DigitalBoard\Models\Program;

class ProgramsExport implements FromCollection
{
    public $programs;

    public function __construct($programs)
    {
        $this->programs = $programs;
    }

    public function collection()
    {
        return Program::select([
            'title',
            'photo',
            'can_show_on_admin'
        ])
            ->whereIn('id', $this->programs)->get();
    }
}
