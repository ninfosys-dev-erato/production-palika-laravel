<?php

namespace Domains\AdminGateway\Recommendation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'recommendation_category_id' =>  [
                'id' => $this->recommendationCategory->id,
                'title' => $this->recommendationCategory->title,
            ],
             'form_id' => $this->whenLoaded('form') ? new RecommedationFormResource($this->form) : null,
            'revenue' => $this->revenue, 
            'is_ward_recommendation' => $this->is_ward_recommendation, 
        ];
    }
}
