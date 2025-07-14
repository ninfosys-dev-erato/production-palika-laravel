<?php

namespace Domains\CustomerGateway\Recommendation\Services;

use Illuminate\Database\Eloquent\Collection;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationService;

class ApplyRecommendationService
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function createRecommendation($data, $customer): ApplyRecommendation|null
    {
        return $this->recommendationService->create($data, $customer);
    }
    public function updateRecommendation( ApplyRecommendation $applyRecommendation, $dto, $customer)
    {
        return $this->recommendationService->update(applyRecommendation: $applyRecommendation, dto: $dto, customer: $customer);
    }
    public function getAppliedRecommendations($customer): Collection
    {
        return $this->recommendationService->getAppliedRecommendations($customer);
    }

    public function getRecommendations($id): Collection
    {
        return $this->recommendationService->getRecommendations($id);
    }
    public function getRecommendationForm($id): Collection
    {
        return $this->recommendationService->getRecommendationForm($id);
    }
    public function getAppliedRecommendationDetail($id)
    {
        return $this->recommendationService->getAppliedRecommendationDetail($id);
    }

    public function getLetter(ApplyRecommendation $applyRecommendation)
    {
        return $this->recommendationService->getLetter($applyRecommendation, 'api');
    }
}
