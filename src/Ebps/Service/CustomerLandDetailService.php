<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Src\Ebps\Models\CustomerLandDetail;

class CustomerLandDetailService
{
public function store(CustomerLandDetailDto $customerLandDetaiAdminDto){
    return CustomerLandDetail::create([
        'customer_id' => $customerLandDetaiAdminDto->customer_id,
        'local_body_id' => $customerLandDetaiAdminDto->local_body_id,
        'ward' => $customerLandDetaiAdminDto->ward,
        'tole' => $customerLandDetaiAdminDto->tole,
        'area_sqm' => $customerLandDetaiAdminDto->area_sqm,
        'lot_no' => $customerLandDetaiAdminDto->lot_no,
        'seat_no' => $customerLandDetaiAdminDto->seat_no,
        'ownership' => $customerLandDetaiAdminDto->ownership,
        'is_landlord' => $customerLandDetaiAdminDto->is_landlord,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(CustomerLandDetail $customerLandDetai, CustomerLandDetailDto $customerLandDetaiAdminDto){
    return tap($customerLandDetai)->update([
        'customer_id' => $customerLandDetaiAdminDto->customer_id,
        'local_body_id' => $customerLandDetaiAdminDto->local_body_id,
        'ward' => $customerLandDetaiAdminDto->ward,
        'tole' => $customerLandDetaiAdminDto->tole,
        'area_sqm' => $customerLandDetaiAdminDto->area_sqm,
        'lot_no' => $customerLandDetaiAdminDto->lot_no,
        'seat_no' => $customerLandDetaiAdminDto->seat_no,
        'ownership' => $customerLandDetaiAdminDto->ownership,
        'is_landlord' => $customerLandDetaiAdminDto->is_landlord,
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
}
public function delete(CustomerLandDetail $customerLandDetai){
    return tap($customerLandDetai)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CustomerLandDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


