<?php

namespace Src\Recommendation\DTO;

use Src\Recommendation\Models\Recommendation;

class RecommendationAdminDto
{
    public function __construct(
        public string $title,
        public string $recommendation_category_id,
        public string $form_id,
        public string $revenue,
        public bool $is_ward_recommendation,
        // public int $notify_to,
        // public int $accepted_by,
        public ?array $recommendationDocuments,
    ) {}

    public static function fromLiveWireArray(array $recommendation): RecommendationAdminDto
    {
        return new self(
            title: $recommendation['title'] ?? '',
            recommendation_category_id: $recommendation['recommendation_category_id'] ?? '',
            form_id: $recommendation['form_id'] ?? '',
            revenue: $recommendation['revenue'] ?? '',
            is_ward_recommendation: $recommendation['is_ward_recommendation'] ?? false,
            // notify_to: $recommendation['notify_to'] ?? '',
            // accepted_by: $recommendation['accepted_by'] ?? '' ,
            recommendationDocuments: $recommendation['recommendationDocuments'] ?? [],
        );
    }

}
