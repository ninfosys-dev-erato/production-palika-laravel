<?php

namespace Src\FileTracking\Controllers;

use App\Facades\GlobalFacade;
use App\Http\Controllers\Controller;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Src\FileTracking\Models\FileRecord;

class DashboardController extends Controller
{
    use HelperDate;
    public function dashboard(): View
    {
        $ward = GlobalFacade::ward();
        $months = $this->getNepaliYearMonthRanges();
        $monthlyData = [];

        // Collect all date ranges
        $dateRanges = array_map(function ($m) {
            return [$m['start_ad'], $m['end_ad']];
        }, $months);

        // Get earliest and latest dates
        $from = min(array_column($months, 'start_ad'));
        $to = max(array_column($months, 'end_ad'));

        // Fetch all records in a single query for the ward within the entire date range
        $records = FileRecord::where('ward', $ward)
            ->whereBetween('registration_date', [$from, $to])
            ->select('registration_date', 'is_chalani')
            ->get();

        $totalDarta = 0;
        $totalChalani = 0;

        foreach ($months as $month) {
            $start = $month['start_ad'];
            $end = $month['end_ad'];

            $filtered = $records->filter(function ($record) use ($start, $end) {
                return $record->registration_date >= $start && $record->registration_date <= $end;
            });

            $grouped = $filtered->groupBy('is_chalani')->map->count();

            $chalani = $grouped->get(1, 0);
            $darta = $grouped->get(0, 0);

            $totalChalani += $chalani;
            $totalDarta += $darta;

            $monthlyData[] = [
                'nepali_month'      => $month['bs_month'],
                'start_ad'          => $start,
                'end_ad'            => $end,
                'chalani_count'     => $chalani,
                'not_chalani_count' => $darta,
            ];
        }

        return view('FileTracking::dashboard', compact('monthlyData', 'totalChalani', 'totalDarta'));
    }
}
