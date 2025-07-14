<?php

namespace Domains\AdminGateway\BusinessRegistration\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Resources\MissingValue|mixed $whenLoaded
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->title_en,
        ];
    }
}