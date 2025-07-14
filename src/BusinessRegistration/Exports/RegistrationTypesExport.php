<?php

namespace Src\BusinessRegistration\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\BusinessRegistration\Models\RegistrationType;

class RegistrationTypeExport extends FromCollection
{
    public $registrationTypes;

    public function __construct($registrationTypes)
    {
        $this->registrationTypes = $registrationTypes;
    }

    public function collection()
    {
        return RegistrationType::select([
            'title',
            'form_id',
            'registration_category_id'
        ])->whereIn('id', $this->registrationTypes)->get();
    }
}
