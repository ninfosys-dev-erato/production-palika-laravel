<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\FormType;

class FormTypesExport implements FromCollection
{
    public $form_types;

    public function __construct($form_types) {
        $this->form_types = $form_types;
    }

    public function collection()
    {
        return FormType::select([
            'name',
            'form_id',
            'status',
            'form_type'
        ])
        ->whereIn('id', $this->form_types)->get();
    }
}
