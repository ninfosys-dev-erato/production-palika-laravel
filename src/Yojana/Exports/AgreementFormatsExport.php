<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\AgreementFormat;

class AgreementFormatsExport implements FromCollection
{
    public $agreement_formats;

    public function __construct($agreement_formats) {
        $this->agreement_formats = $agreement_formats;
    }

    public function collection()
    {
        return AgreementFormat::select([
'implementation_method_id',
'name',
'sample_letter'
])
        ->whereIn('id', $this->agreement_formats)->get();
    }
}


