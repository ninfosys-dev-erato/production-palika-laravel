<?php

namespace Domains\CustomerGateway\Grievance\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrievanceAssignHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $documentPath = config('src.Grievance.grievance.path');
        return [
            'id' => $this->id,
            'grievance_detail_id' => $this->grievance_detail_id,
            'old_status' => $this->old_status,
            'new_status' => $this->new_status,
            'documents' => $this->documents ? array_map(
                fn($document) => ImageServiceFacade::getImage($documentPath, $document, 'local'),
                $this->documents
            ) : null,
            'suggestions' => $this->suggestions,
            ];
    }
}
