<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;

class BerujuDashboardController extends Controller implements HasMiddleware
{
    use HelperDate;
    public static function middleware()
    {
        return [
            new Middleware('permission:beruju access', only: ['index']),
            new Middleware('permission:beruju create', only: ['create']),
            new Middleware('permission:beruju edit', only: ['edit']),
            new Middleware('permission:beruju view', only: ['view', 'preview']),
        ];
    }

    public function index(Request $request)
    {
        $currentFiscalYearId = key(getSettingWithKey('fiscal-year'));
        $currentFiscalYear = getSetting('fiscal-year');


        $allBerujuEntries = BerujuEntry::whereNull('deleted_at')
            ->with(['fiscalYear', 'subCategory', 'branch'])
            ->get();
        $totalOverdue = $allBerujuEntries
            ->where('fiscal_year_id', $currentFiscalYearId)
            ->whereNotIn('status', [
                BerujuStatusEnum::RESOLVED,
                BerujuStatusEnum::PARTIALLY_RESOLVED
            ])
            ->filter(function ($item) {
                $deadlineAd = $this->bsToAd($item->action_deadline);
                return $deadlineAd < now();
            })
            ->count();


        $totalMultiYearOutStanding = $allBerujuEntries
            ->where('fiscal_year_id', $currentFiscalYearId)
            ->whereNotIn('status', [
                BerujuStatusEnum::RESOLVED,
                BerujuStatusEnum::PARTIALLY_RESOLVED
            ])
            ->filter(fn($item) => $this->bsToAd($item->action_deadline) < now()->subYears(2))
            ->count();


        $resolvedCount = $allBerujuEntries->whereIn('status', [
            BerujuStatusEnum::RESOLVED,
            BerujuStatusEnum::PARTIALLY_RESOLVED
        ])->where('fiscal_year_id', $currentFiscalYearId)
            ->count();

        $unresolvedCount = $allBerujuEntries->whereIn('status', [
            BerujuStatusEnum::DRAFT,
            BerujuStatusEnum::SUBMITTED,
            BerujuStatusEnum::ASSIGNED,
            BerujuStatusEnum::ACTION_TAKEN,
            BerujuStatusEnum::UNDER_REVIEW,
            BerujuStatusEnum::REJECTED_NOT_RESOLVED,
            BerujuStatusEnum::ARCHIVED,
        ])->where('fiscal_year_id', $currentFiscalYearId)
            ->count();

        // Get recent entries for the table
        $allBeruju = $allBerujuEntries->sortByDesc('created_at')->where('fiscal_year_id', $currentFiscalYearId)->take(10);

        // Group by branch for current fiscal year
        $departmentBeruju = $allBerujuEntries
            ->where('fiscal_year_id', $currentFiscalYearId)

            ->groupBy('branch_id')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'branch_name' => $group->first()->branch?->title ?? 'Unknown Branch',
                ];
            });

        // Group by category for amount summary
        $berujuCategoryAmount = $allBerujuEntries
            ->whereNotNull('amount')
            ->where('fiscal_year_id', $currentFiscalYearId)
            ->where('amount', '!=', '')
            ->where('amount', '!=', '0')
            ->groupBy('beruju_category')
            ->map(function ($group) {
                $totalAmount = $group->sum(function ($item) {
                    return $item->amount;
                });

                if ($totalAmount > 0) {
                    return [
                        'category' => $group->first()->beruju_category->label(),
                        'total_count' => $group->count(),
                        'total_amount' => $totalAmount,
                    ];
                }
                return null;
            })
            ->filter()
            ->values();

        // Group by fiscal year for status summary
        $berujuByFiscalYear = $allBerujuEntries
            ->groupBy('fiscal_year_id')
            ->map(function ($group) {
                return [
                    'fiscal_year' => $group->first()->fiscalYear?->year ?? 'Unknown Year',
                    'total_count' => $group->count(),
                    'resolved_count' => $group->whereIn('status', [
                        BerujuStatusEnum::RESOLVED,
                        BerujuStatusEnum::PARTIALLY_RESOLVED
                    ])->count(),
                    'archived_count' => $group->where('status', BerujuStatusEnum::ARCHIVED)->count(),
                    'rejected_count' => $group->where('status', BerujuStatusEnum::REJECTED_NOT_RESOLVED)->count(),
                ];
            })
            ->values();

        return view('Beruju::menu.dashboard', compact(
            'resolvedCount',
            'unresolvedCount',
            'allBeruju',
            'departmentBeruju',
            'berujuCategoryAmount',
            'berujuByFiscalYear',
            'currentFiscalYear',
            'totalOverdue',
            'totalMultiYearOutStanding'
        ));
    }
}
