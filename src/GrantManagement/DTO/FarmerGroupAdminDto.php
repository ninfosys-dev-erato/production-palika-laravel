<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\FarmerGroup;

class FarmerGroupAdminDto
{
   public function __construct(
        public string $farmer_id,
        public string $group_id
    ){}

public static function fromLiveWireModel(FarmerGroup $farmerGroup):FarmerGroupAdminDto{
    return new self(
        farmer_id: $farmerGroup->farmer_id,
        group_id: $farmerGroup->group_id
    );
}
}
