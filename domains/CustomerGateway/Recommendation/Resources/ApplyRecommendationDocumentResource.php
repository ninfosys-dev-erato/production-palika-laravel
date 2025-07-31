<?php

namespace Domains\CustomerGateway\Recommendation\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplyRecommendationDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $documentPath = config('src.Recommendation.recommendation.path');

        return [
            'id' => $this->id,
            'apply_recommendation_id' => $this->apply_recommendation_id,
            'title' => $this->title,
            'document' => ImageServiceFacade::getImage($documentPath, $this->document, getStorageDisk('private')),
            'status' => $this->status, 
            'remarks' => $this->remarks, 

        ];
    }
}
