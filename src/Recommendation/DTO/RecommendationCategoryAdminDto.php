<?php

namespace Src\Recommendation\DTO;

use Src\Recommendation\Models\RecommendationCategory;

class RecommendationCategoryAdminDto

{
    public function __construct(
        public string $title,
    ){}

    public static function fromLiveWireModel(RecommendationCategory $recommendationCategory):RecommendationCategoryAdminDto{
        return new self(
            title: $recommendationCategory->title,
        );
    }
}
