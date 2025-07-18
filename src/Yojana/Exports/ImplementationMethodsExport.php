<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ImplementationMethod;

class ImplementationMethodsExport implements FromCollection
{
    public $implementation_methods;

    public function __construct($implementation_methods) {
        $this->implementation_methods = $implementation_methods;
    }

    public function collection()
    {
        return ImplementationMethod::select([
'title',
'code',
'model'
])
        ->whereIn('id', $this->implementation_methods)->get();
    }
}


