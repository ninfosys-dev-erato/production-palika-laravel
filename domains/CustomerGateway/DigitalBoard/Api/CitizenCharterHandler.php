<?php

namespace Domains\CustomerGateway\DigitalBoard\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\DigitalBoard\Resources\CharterResource;
use Domains\CustomerGateway\DigitalBoard\Services\DomainDigitalBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CitizenCharterHandler extends Controller
{

    use ApiStandardResponse;
    protected $domainDigitalBoardService;

    public function __construct(DomainDigitalBoardService $domainDigitalBoardService)
    {
        $this->domainDigitalBoardService = $domainDigitalBoardService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $charters = $this->domainDigitalBoardService->showCharters(); 
        return CharterResource::collection($charters);
    }

    public function showDetail(int $id): CharterResource|JsonResponse
    {
        $charter = $this->domainDigitalBoardService->showCharterDetail($id); 
        if(empty($charter)){
            return $this->generalFailure(['message' => 'Citizen charter not found'], 404);
        }
        return new CharterResource($charter);
    }
}