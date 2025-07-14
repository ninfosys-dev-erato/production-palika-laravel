<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\CustomerFamilyDetail;

class CustomerFamilyDetailsExport implements FromCollection
{
    public $customer_family_details;

    public function __construct($customer_family_details) {
        $this->customer_family_details = $customer_family_details;
    }

    public function collection()
    {
        return CustomerFamilyDetail::select([
'customer_id',
'father_name',
'mother_name',
'grandfather_name',
'grandmother_name',
'great_grandfather_name'
])
        ->whereIn('id', $this->customer_family_details)->get();
    }
}


