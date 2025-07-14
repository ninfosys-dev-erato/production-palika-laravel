<?php

namespace Domains\CustomerGateway\Downloads\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Downloads\Resources\DownloadResource;
use Domains\CustomerGateway\Downloads\Services\DomainDownloadService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DownloadHandler extends Controller
{
    use ApiStandardResponse;
    protected $domainDownloadService;

    public function __construct(DomainDownloadService $domainDownloadService)
    {
        $this->domainDownloadService = $domainDownloadService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $downloads =$this->domainDownloadService->showDownloadList(); 
        return DownloadResource::collection($downloads);
    }
}