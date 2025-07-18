<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\CooperativeFarmer;

class CooperativeFarmerAdminDto
{
   public function __construct(
        public string $cooperative_id,
        public string $farmer_id
    ){}

public static function fromLiveWireModel(CooperativeFarmer $cooperativeFarmer):CooperativeFarmerAdminDto{
    return new self(
        cooperative_id: $cooperativeFarmer->cooperative_id,
        farmer_id: $cooperativeFarmer->farmer_id
    );
}
}
