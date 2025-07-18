<?php

namespace Domains\CustomerGateway\Downloads\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Downloads\Service\DownloadService;

class DomainDownloadService
{
    protected $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    public function showDownloadList(): LengthAwarePaginator
    {
        return $this->downloadService->show();
    }

}