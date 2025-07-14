<?php

namespace Domains\AdminGateway\BusinessRegistration\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_ne' => $this->title_ne,
        ];
    }
}