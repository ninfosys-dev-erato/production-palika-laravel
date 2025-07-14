<?php

namespace Domains\AdminGateway\Recommendation\Resources;

use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Recommendation\Models\Recommendation;

class ApplyRecommendationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer' => $this->whenLoaded('customer', fn () => new \Src\Customers\Resources\CustomerResouce($this->customer)),
            'recommendation_id' => $this->whenLoaded('recommendation') ? new RecommendationResource($this->recommendation) : null,
            'data' => $this->transformData(array_values((array) json_decode($this->data, true)),),
            'status' => $this->status,
            'remarks' => $this->remarks,
            'document' => $this->whenLoaded('documents')
                ? ApplyRecommendationDocumentResource::collection($this->documents)
                : null,
            'rejected_at' => $this->rejected_at,
            'rejected_reason' => $this->rejected_reason,
            'bill'=> $this->bill ? ImageServiceFacade::getImage(config('src.Recommendation.recommendation.bill'), $this->bill, 'local') : null,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
            'created_at_date' => Carbon::parse($this->created_at)->toDateString()
        ];
    }

    private function transformData(array $data): array
    {
        return array_map(function ($item) {
            if ($item['type'] === 'table' && isset($item['value'])) {
                $item['value'] = array_map(function ($row) {
                    return array_values($row);
                }, $item['value']);
            }
            return $item;
        }, $data);
    }
}
