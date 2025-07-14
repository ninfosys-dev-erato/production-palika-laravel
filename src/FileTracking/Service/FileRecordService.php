<?php

namespace Src\FileTracking\Service;

use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Src\FileTracking\Enums\SenderMediumEnum;
use Src\FileTracking\Models\FileRecord;

class FileRecordService
{
    public function search() : QueryBuilder
    {
        return QueryBuilder::for(FileRecord::class)
            ->whereNull('deleted_by')
            ->whereNull('deleted_at')
            ->allowedFilters([
                AllowedFilter::exact('reg_no'),
                AllowedFilter::exact('applicant_name'),
                'applicant_address',
                AllowedFilter::exact('applicant_mobile_no'),
                'document_level',
                AllowedFilter::exact('sender_medium',SenderMediumEnum::class),
                AllowedFilter::callback('record_type', function (Builder $query, $value) {
                    switch ($value) {
                        case 'darta':
                            $query->where('is_chalani', false);
                            break;
                        case 'chalani':
                            $query->where('is_chalani', true);
                    }
                }),
            ])
            ->with('logs')
            ->allowedSorts(['reg_no', 'created_at', ]);
    }
}