<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\LetterType;

class LetterTypesExport implements FromCollection
{
    public $letter_types;

    public function __construct($letter_types) {
        $this->letter_types = $letter_types;
    }

    public function collection()
    {
        return LetterType::select([
'title'
])
        ->whereIn('id', $this->letter_types)->get();
    }
}


