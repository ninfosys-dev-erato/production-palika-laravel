<?php

namespace Domains\CustomerGateway\Grievance\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrievanceFileResource extends JsonResource
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
            'grievance_detail_id' => $this->grievance_detail_id,
            'files' => $this->file_name
        ];
    }
}
