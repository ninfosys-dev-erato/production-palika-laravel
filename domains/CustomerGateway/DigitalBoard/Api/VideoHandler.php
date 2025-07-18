<?php

namespace Domains\CustomerGateway\DigitalBoard\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\DigitalBoard\Resources\VideoResource;
use Domains\CustomerGateway\DigitalBoard\Services\DomainDigitalBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoHandler extends Controller
{

    use ApiStandardResponse;
    protected $domainDigitalBoardService;

    public function __construct(DomainDigitalBoardService $domainDigitalBoardService)
    {
        $this->domainDigitalBoardService = $domainDigitalBoardService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $videos = $this->domainDigitalBoardService->showVideos(); 
        return VideoResource::collection($videos);
    }

    public function showDetail(int $id): JsonResponse|VideoResource
    {
        $video = $this->domainDigitalBoardService->showVideoDetail($id); 
        if(empty($video))
        {
            return $this->generalFailure(['message' => 'Video not found'], 404);
        }
        return new VideoResource($video);
    }
}