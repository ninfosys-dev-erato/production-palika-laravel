<?php

namespace Domains\AdminGateway\BusinessRegistration\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocalBodyResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->title_en,
        ];
    }
}