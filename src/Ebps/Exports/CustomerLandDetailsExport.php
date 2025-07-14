<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\CustomerLandDetail;

class CustomerLandDetailsExport implements FromCollection
{
    public $customer_land_detais;

    public function __construct($customer_land_detais) {
        $this->customer_land_detais = $customer_land_detais;
    }

    public function collection()
    {
        return CustomerLandDetail::select([
'customer_id',
'local_body_id',
'ward',
'tole',
'area_sqm',
'lot_no',
'seat_no',
'ownership',
'is_landlord'
])
        ->whereIn('id', $this->customer_land_detais)->get();
    }
}


