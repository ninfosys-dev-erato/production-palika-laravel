<?php

namespace Src\Recommendation\DTO;

use Src\Recommendation\Models\ApplyRecommendation;

class ApplyRecommendationShowDto
{
    public function __construct(
        public ?string $reviewed_by,
        public ?string $bill,
        public ?string $reviewed_at,
        public ?int $accepted_by,
        public ?string $accepted_at,
        public ?int $rejected_by,
        public ?string $rejected_at,
        public ?string $rejected_reason,
        public ?string $ltax_ebp_code,
    ){}

    public static function fromModel(ApplyRecommendation $applyRecommendation): self
    {
        return new self(
            reviewed_by: $applyRecommendation->reviewed_by,
            bill: $applyRecommendation->bill,
            reviewed_at: $applyRecommendation->reviewed_at,
            accepted_by: $applyRecommendation->accepted_by,
            accepted_at: $applyRecommendation->accepted_at,
            rejected_by: $applyRecommendation->rejected_by,
            rejected_at: $applyRecommendation->rejected_at,
            rejected_reason: $applyRecommendation->rejected_reason,
            ltax_ebp_code: $applyRecommendation->ltax_ebp_code,
        );
    }
}
