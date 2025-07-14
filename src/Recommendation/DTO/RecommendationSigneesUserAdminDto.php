<?php

namespace Src\Recommendation\DTO;

use Src\Recommendation\Models\RecommendationSigneesUser;

class RecommendationSigneesUserAdminDto
{
   public function __construct(
        public int $user_id,
        public int $ward_id,
        public int $recommendation_type_id
    ){}

public static function fromLiveWireModel(int $user_id,int $ward_id,int $recommendation_type_id):RecommendationSigneesUserAdminDto{
    return new self(
        user_id: $user_id,
        ward_id: $ward_id,
        recommendation_type_id: $recommendation_type_id
    );
}
}
