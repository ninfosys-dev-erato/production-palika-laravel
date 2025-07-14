<?php

namespace Frontend\CustomerPortal\Recommendation\DTO;

use Illuminate\Support\Facades\Auth;
use Src\Recommendation\Enums\RecommendationMediumEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;

class ApplyRecommendationAdminDto
{
    public function __construct(
        public string $customer_id,
        public string $recommendation_id,
        public array $data,
        public ?string $remarks,
        public ?string $signee_id,
        public ?string $signee_type,
        public ?RecommendationMediumEnum $recommendation_medium,
        public ?string $fiscal_year_id,
        public ?string $ward_id,
        public ?string $local_body_id
    ){}

    public static function fromLiveWireModel(ApplyRecommendation $applyRecommendation):ApplyRecommendationAdminDto{
        $customer = Auth::guard('customer')->user()?->load('kyc');
        $recommendation = Recommendation::with('signees.user')->find($applyRecommendation->recommendation_id);
        if (!$recommendation) {
            throw new \Exception('Recommendation not found');
        }
        $firstSignee = $recommendation->signees->isNotEmpty() ? $recommendation->signees->first() : null;

        return new self(
            customer_id: $applyRecommendation->customer_id,
            recommendation_id: $applyRecommendation->recommendation_id,
            data: $applyRecommendation->data ?? [],
            remarks: $applyRecommendation->remarks ?? null,
            signee_id: $firstSignee ? $firstSignee->user_id : null,
            signee_type: $firstSignee ? get_class($firstSignee) : null,
            recommendation_medium: RecommendationMediumEnum::WEB,
            ward_id: $customer->kyc->permanent_ward,
            local_body_id: $customer->kyc->permanent_local_body_id,
            fiscal_year_id:  key(getSettingWithKey('fiscal-year'))
        );
    }
}
