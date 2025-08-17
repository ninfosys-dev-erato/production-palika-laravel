<?php

namespace Src\Recommendation\DTO;

use App\Facades\GlobalFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Src\Recommendation\Enums\RecommendationMediumEnum;
use Src\Recommendation\Models\ApplyRecommendation;

class ApplyRecommendationAdminDto
{
    public function __construct(
        public string $customer_id,
        public string $recommendation_id,
        public array $data,
        public ?string $remarks,
        public ?bool $is_ward,
        public ?Model $signee,
        public ?string $signee_id,
        public ?string $signee_type,
        public ?RecommendationMediumEnum $recommendation_medium,
        public ?string $fiscal_year_id,
        public ?string $ward_id,
        public ?string $local_body_id,
    ){}

    public static function fromLiveWireModel(ApplyRecommendation $applyRecommendation):ApplyRecommendationAdminDto{
    
        $is_ward = $applyRecommendation->recommendation->is_ward_recommendation;

        $customer = $applyRecommendation->customer; // Assumes 'customer' relationship is loaded

        if (Auth::guard('customer')->check()) {
            $recommendation_medium = RecommendationMediumEnum::WEB;
            $ward = $customer->kyc->ward_id ?? null;
            $localBody = $customer->kyc->permanent_local_body_id ?? null;
        } elseif (Auth::guard('api-customer')->check()) {
            $recommendation_medium = RecommendationMediumEnum::MOBILE;
            $ward = $customer->kyc->ward_id ?? null;
            $localBody = $customer->kyc->permanent_local_body_id ?? null;
        } elseif (Auth::guard('web')->check()) {
            $recommendation_medium = RecommendationMediumEnum::SYSTEM;
            $ward = GlobalFacade::ward() ?? null;
            $localBody = key(getSettingWithKey('palika-local-body')) ?? null;
        } else {
            $recommendation_medium = null;
            $ward = null;
            $localBody = null;
        }
        return new self(
            customer_id: $applyRecommendation->customer_id,
            recommendation_id: $applyRecommendation->recommendation_id,
            data: $applyRecommendation->data ?? [],
            remarks: $applyRecommendation->remarks ?? null,
            is_ward: $is_ward,
            signee: $applyRecommendation->signee ?? null,
            signee_id: $applyRecommendation->signee_id ?? null, 
            signee_type: $applyRecommendation->signee_type ?? null,
            recommendation_medium: $recommendation_medium ?? null,
            fiscal_year_id: $applyRecommendation->fiscal_year_id ?? null,
            ward_id: $ward ?? null,
            local_body_id: $localBody ?? null,

        );
    }
}
