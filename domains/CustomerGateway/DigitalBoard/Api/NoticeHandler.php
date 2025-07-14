<?php

namespace Domains\CustomerGateway\DigitalBoard\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\DigitalBoard\Resources\NoticeResource;
use Domains\CustomerGateway\DigitalBoard\Services\DomainDigitalBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoticeHandler extends Controller
{

    use ApiStandardResponse;
    protected $domainDigitalBoardService;

    public function __construct(DomainDigitalBoardService $domainDigitalBoardService)
    {
        $this->domainDigitalBoardService = $domainDigitalBoardService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $notices = $this->domainDigitalBoardService->showNotices(); 
        return NoticeResource::collection($notices);
    }
    public function showDetail(int $id): JsonResponse|NoticeResource
    {
        $notices = $this->domainDigitalBoardService->showNoticeDetail($id); 

        if(empty($notices)){
            return $this->generalFailure(['message' => 'Citizen charter not found'], 404);
        }
        return new NoticeResource($notices);
    }
}