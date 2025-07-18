<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\EnterpriseFarmer;

class EnterpriseFarmerAdminDto
{
   public function __construct(
        public string $enterprise_id,
        public string $farmer_id
    ){}

public static function fromLiveWireModel(EnterpriseFarmer $enterpriseFarmer):EnterpriseFarmerAdminDto{
    return new self(
        enterprise_id: $enterpriseFarmer->enterprise_id,
        farmer_id: $enterpriseFarmer->farmer_id
    );
}
}
