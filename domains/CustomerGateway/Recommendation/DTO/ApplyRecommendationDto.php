<?php

namespace Domains\CustomerGateway\Recommendation\DTO;

use Illuminate\Support\Facades\Auth;
use Src\Recommendation\Enums\RecommendationMediumEnum;
use Src\Recommendation\Models\Recommendation;

class ApplyRecommendationDto
{
    public function __construct(
        public readonly int $recommendation_id,
        public readonly array $data,
        public readonly ?string $remarks,
        public readonly ?array $documents,
        public ?bool $is_ward,
        public ?string $signee_id,
        public ?string $signee_type,
        public ?RecommendationMediumEnum $recommendation_medium,
        public ?int $fiscal_year_id,
        public ?string $ward_id,
        public ?string $local_body_id


    ) {}

    public static function fromValidatedRequest(array $request): ApplyRecommendationDto
    {
        $customer = auth()->user()?->load('kyc');
        $recommendation = Recommendation::with('signees.user')->find($request['recommendation_id']);
        if (!$recommendation) {
            throw new \Exception('Recommendation not found');
        }
        $firstSignee = $recommendation->signees->isNotEmpty() ? $recommendation->signees->first() : null;

        return new self(
            recommendation_id: $request['recommendation_id']?? null,
            data: $request['data']?? null,
            remarks: $request['remarks']?? null,
            documents: $request['documents'] ?? null,
            is_ward: $request['is_ward'] ?? null,
            signee_id : $firstSignee ? $firstSignee->user_id : null,
            signee_type : $firstSignee ? get_class($firstSignee) : null,
            recommendation_medium: RecommendationMediumEnum::MOBILE,
            ward_id: $customer->kyc->permanent_ward,
            local_body_id: $customer->kyc->permanent_local_body_id,
            fiscal_year_id: key(getSettingWithKey('fiscal-year'))
        );
    }
}
