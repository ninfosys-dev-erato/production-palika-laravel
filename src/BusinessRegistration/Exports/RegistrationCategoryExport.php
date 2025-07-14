<?php

namespace Src\BusinessRegistration\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\BusinessRegistration\Models\RegistrationCategory;

class RegistrationCategoryExport extends FromCollection
{
    public $registrationCategories;

    public function __construct($registrationCategories)
    {
        $this->registrationCategories = $registrationCategories;
    }

    public function collection()
    {
        return RegistrationCategory::select([
            'title',
        ])->whereIn('id', $this->registrationCategories)->get();
    }
}
