<?php

namespace Domains\CustomerGateway\Downloads\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DownloadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $filePath = config('src.Downloads.download.file_path');
        return [
            'id' => (int) $this->id,
            'title' => (string) $this->title,
            'title_en' => (string) $this->title_en,
            'files' => $this->files 
            ? array_map(
                fn($file) => ImageServiceFacade::getImage($filePath, $file),
                $this->files
              ) 
            : [],
            'status' => (bool)$this->status,
            'order' => (int)$this->order  
        ];
    }

   
}
