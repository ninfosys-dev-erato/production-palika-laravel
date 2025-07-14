<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\LetterSample;

class LetterSamplesExport implements FromCollection
{
    public $letter_samples;

    public function __construct($letter_samples) {
        $this->letter_samples = $letter_samples;
    }

    public function collection()
    {
        return LetterSample::select([
'letter_type',
'implementation_method_id',
'name',
'subject',
'sample_letter'
])
        ->whereIn('id', $this->letter_samples)->get();
    }
}


