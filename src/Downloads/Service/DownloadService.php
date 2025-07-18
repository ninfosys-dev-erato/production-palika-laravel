<?php

namespace Src\Downloads\Service;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Downloads\Models\Download;

class DownloadService
{
    public function show(): LengthAwarePaginator
    {
        $downloads = QueryBuilder::for(Download::class)
            ->allowedFilters(['title', 'title_en'])
            ->allowedSorts(['title', 'status', 'created_at'])
            ->where('status', true)
            ->whereNull('deleted_at')
            ->paginate(15);

        return $downloads;
    }
    
}