<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\CustomerFamilyDetail;

class CustomerFamilyDetailAdminDto
{
   public function __construct(
        public string $customer_id,
        public string $father_name,
        public string $mother_name,
        public string $grandfather_name,
        public string $grandmother_name,
        public string $great_grandfather_name
    ){}

public static function fromLiveWireModel(CustomerFamilyDetail $customerFamilyDetail):CustomerFamilyDetailAdminDto{
    return new self(
        customer_id: $customerFamilyDetail->customer_id,
        father_name: $customerFamilyDetail->father_name,
        mother_name: $customerFamilyDetail->mother_name,
        grandfather_name: $customerFamilyDetail->grandfather_name,
        grandmother_name: $customerFamilyDetail->grandmother_name,
        great_grandfather_name: $customerFamilyDetail->great_grandfather_name
    );
}
}
