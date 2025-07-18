<?php

namespace Src\TokenTracking\DTO;

use Src\TokenTracking\Models\TokenFeedback;

class TokenFeedbackAdminDto
{
    public function __construct(
        public int $token_id,
        public ?string $feedback,
        public ?string $rating,
        public string $service_quality,
        public string $service_accesibility,
        public string $citizen_satisfaction,
    ) {}

    public static function fromLiveWireModel(TokenFeedback $tokenFeedback): TokenFeedbackAdminDto
    {
        return new self(
            token_id: $tokenFeedback->token_id,
            feedback: $tokenFeedback->feedback,
            rating: $tokenFeedback->rating,
            service_quality: $tokenFeedback->service_quality,
            service_accesibility: $tokenFeedback->service_accesibility,
            citizen_satisfaction: $tokenFeedback->citizen_satisfaction
        );
    }
}
