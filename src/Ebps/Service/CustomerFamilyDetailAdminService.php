<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\CustomerFamilyDetailAdminDto;
use Src\Ebps\Models\CustomerFamilyDetail;

class CustomerFamilyDetailAdminService
{
public function store(CustomerFamilyDetailAdminDto $customerFamilyDetailAdminDto){
    return CustomerFamilyDetail::create([
        'customer_id' => $customerFamilyDetailAdminDto->customer_id,
        'father_name' => $customerFamilyDetailAdminDto->father_name,
        'mother_name' => $customerFamilyDetailAdminDto->mother_name,
        'grandfather_name' => $customerFamilyDetailAdminDto->grandfather_name,
        'grandmother_name' => $customerFamilyDetailAdminDto->grandmother_name,
        'great_grandfather_name' => $customerFamilyDetailAdminDto->great_grandfather_name,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CustomerFamilyDetail $customerFamilyDetail, CustomerFamilyDetailAdminDto $customerFamilyDetailAdminDto){
    return tap($customerFamilyDetail)->update([
        'customer_id' => $customerFamilyDetailAdminDto->customer_id,
        'father_name' => $customerFamilyDetailAdminDto->father_name,
        'mother_name' => $customerFamilyDetailAdminDto->mother_name,
        'grandfather_name' => $customerFamilyDetailAdminDto->grandfather_name,
        'grandmother_name' => $customerFamilyDetailAdminDto->grandmother_name,
        'great_grandfather_name' => $customerFamilyDetailAdminDto->great_grandfather_name,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CustomerFamilyDetail $customerFamilyDetail){
    return tap($customerFamilyDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CustomerFamilyDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


