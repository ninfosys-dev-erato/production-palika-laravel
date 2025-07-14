<?php

namespace Domains\CustomerGateway\Grievance\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrievanceDetailResource extends JsonResource
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
            'token' => $this->token,
            'grievance_detail_id' => $this->whenLoaded('grievanceDetail') ? new GrievanceDetailResource($this->grievanceDetail) : null,
            'grievance_type_id' => $this->whenLoaded('grievanceType') ? new GrievanceTypeResource($this->grievanceType) : null,
            'branch_id' => $this->whenLoaded('branch') ? new GrievanceBranchResource($this->branch) : null,
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
            'approved_at' => $this->approved_at,
            'is_public' => $this->is_public,
            'grievance_medium' => $this->grievance_medium,
            'is_anonymous' => $this->is_anonymous,
            'files' => $this->whenLoaded('files') ? GrievanceFileResource::collection($this->files) : null,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
            'investigation_type' => $this->investigation_type,
            'histories' => $this->whenLoaded('histories') ? GrievanceAssignHistoryResource::collection($this->histories) : null
        ];
    }
}
