<?php

namespace Domains\CustomerGateway\DigitalBoard\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\DigitalBoard\Resources\PopUpResource;
use Domains\CustomerGateway\DigitalBoard\Services\DomainDigitalBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PopUpHandler extends Controller
{

    use ApiStandardResponse;
    protected $domainDigitalBoardService;

    public function __construct(DomainDigitalBoardService $domainDigitalBoardService)
    {
        $this->domainDigitalBoardService = $domainDigitalBoardService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $popups = $this->domainDigitalBoardService->showPopUps(); 
        return PopUpResource::collection($popups);
    }

    public function showDetail(int $id): JsonResponse|PopUpResource
    {
        $popup = $this->domainDigitalBoardService->showPopUpDetail($id); 
        if(empty($popup))
        {
            return $this->generalFailure(['message' => 'PopUp not found'], 404);
        }
        return new PopUpResource($popup);
    }
}