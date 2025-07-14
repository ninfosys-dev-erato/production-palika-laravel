<?php

namespace Domains\CustomerGateway\DigitalBoard\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\DigitalBoard\Resources\ProgramResource;
use Domains\CustomerGateway\DigitalBoard\Services\DomainDigitalBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProgramHandler extends Controller
{

    use ApiStandardResponse;
    protected $domainDigitalBoardService;

    public function __construct(DomainDigitalBoardService $domainDigitalBoardService)
    {
        $this->domainDigitalBoardService = $domainDigitalBoardService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $programs = $this->domainDigitalBoardService->showPrograms(); 
        return ProgramResource::collection($programs);
    }

    public function showDetail(int $id): JsonResponse|ProgramResource
    {
        $program = $this->domainDigitalBoardService->showProgramDetail($id); 
        if(empty($program))
        {
            return $this->generalFailure(['message' => 'Program not found'], 404);
        }
        return new ProgramResource($program);
    }
}