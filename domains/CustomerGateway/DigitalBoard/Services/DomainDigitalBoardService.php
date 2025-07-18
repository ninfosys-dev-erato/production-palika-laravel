<?php
namespace Domains\CustomerGateway\DigitalBoard\Services;

use App\Traits\ApiStandardResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;

class DomainDigitalBoardService
{
    use ApiStandardResponse;
    public function showNotices(): LengthAwarePaginator
    {
        return QueryBuilder::for(Notice::class)
            ->with('wards')
            ->whereNull('deleted_at')
            ->allowedFilters([
                'title',
                'date',
                AllowedFilter::exact('can_show_on_admin'),
                AllowedFilter::scope('start_date'),
                AllowedFilter::scope('end_date'),
                AllowedFilter::callback('ward', function ($query, $value) {
                    $query->whereHas('wards', function ($query) use ($value) {
                        $query->where('ward', $value);
                    });
                })
            ])
            ->allowedSorts(['title', 'created_at'])
            ->orderBy('tbl_notices.created_at', 'desc')
            ->paginate(10);

    }
    public function showNoticeDetail(int $id)
    {
        return Notice::where('id', $id)
            ->with('wards')
            ->whereNull('deleted_at')
            ->first();

    }

    public function showPrograms(): LengthAwarePaginator
    {
        return QueryBuilder::for(Program::class)
            ->with('wards')
            ->whereNull('deleted_at')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('can_show_on_admin'),
                AllowedFilter::scope('start_date'),
                AllowedFilter::scope('end_date'),
                AllowedFilter::callback('ward', function ($query, $value) {
                    $query->whereHas('wards', function ($query) use ($value) {
                        $query->where('ward', $value);
                    });
                })
            ])
            ->allowedSorts(['title', 'created_at'])
            ->orderBy('tbl_programs.created_at', 'desc')
            ->paginate(10);

    }

    public function showProgramDetail(int $id)
    {
        return Program::where('id', $id)
            ->with('wards')
            ->whereNull('deleted_at')
            ->first();

    }
    public function showVideos(): LengthAwarePaginator
    {
        return QueryBuilder::for(Video::class)
            ->with('wards')
            ->whereNull('deleted_at')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('can_show_on_admin'),
                AllowedFilter::scope('start_date'),
                AllowedFilter::scope('end_date'),
                AllowedFilter::callback('ward', function ($query, $value) {
                    $query->whereHas('wards', function ($query) use ($value) {
                        $query->where('ward', $value);
                    });
                })
            ])
            ->allowedSorts(['title', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

    }

    public function showVideoDetail(int $id)
    {
        return Video::where('id', $id)
            ->with('wards')
            ->whereNull('deleted_at')
            ->first();
    }
    public function showPopUps(): LengthAwarePaginator
    {
        return QueryBuilder::for(PopUp::class)
            ->with('wards')
            ->whereNull('deleted_at')
            ->allowedFilters([
                'title',
                'is_active',
                'iteration_duration',
                'display_duration',
                AllowedFilter::exact('can_show_on_admin'),
                AllowedFilter::scope('start_date'),
                AllowedFilter::scope('end_date'),
                AllowedFilter::callback('ward', function ($query, $value) {
                    $query->whereHas('wards', function ($query) use ($value) {
                        $query->where('ward', $value);
                    });
                })
            ])
            ->allowedSorts(['title', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

    }

    public function showPopUpDetail(int $id)
    {
        return Popup::where('id', $id)
            ->with('wards')
            ->whereNull('deleted_at')
            ->first();
    }


    public function showCharters(): LengthAwarePaginator
    {
        return QueryBuilder::for(CitizenCharter::class)
            ->with('wards', 'branch') 
            ->whereNull('deleted_at')
            ->allowedFilters([
                'service',
                'required_document',
                'amount',
                'time',
                'responsible_person',
                AllowedFilter::exact('can_show_on_admin'),
                AllowedFilter::scope('start_date'),
                AllowedFilter::scope('end_date'),
                AllowedFilter::callback('ward', function ($query, $value) {
                    $query->whereHas('wards', function ($query) use ($value) {
                        $query->where('ward', $value);
                    });
                })
            ])
            ->allowedSorts(['service', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function showCharterDetail(int $id)
    {
        return CitizenCharter::where('id', $id)
            ->with('wards', 'branch')
            ->whereNull('deleted_at')
            ->first();
    }
}