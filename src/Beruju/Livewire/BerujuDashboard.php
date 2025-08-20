<?php

namespace Src\Beruju\Livewire;

use App\Traits\HelperDate;
use Livewire\Component;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\FiscalYears\Models\FiscalYear;

class BerujuDashboard extends Component
{
    use HelperDate;

    public $resolvedCount = 0;
    public $unresolvedCount = 0;
    public $allBeruju;
    public $departmentBeruju;
    public $berujuCategoryAmount;
    public $berujuByFiscalYear;
    public $currentFiscalYear = '';
    public $currentFiscalYearId = '';
    public $totalOverdue = 0;
    public $totalMultiYearOutStanding = 0;
    public $selectedFiscalYear = '';
    public $fiscalYears;

    public function mount()
    {
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->currentFiscalYearId = key(getSettingWithKey('fiscal-year'));
        $this->currentFiscalYear = getSetting('fiscal-year');
        $this->selectedFiscalYear = $this->currentFiscalYearId;
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $allBerujuEntries = BerujuEntry::whereNull('deleted_at')
            ->with(['fiscalYear', 'subCategory', 'branch'])
            ->get();

        $this->totalOverdue = $allBerujuEntries
            ->where('fiscal_year_id', $this->currentFiscalYearId)
            ->whereNotIn('status', [
                BerujuStatusEnum::RESOLVED,
                BerujuStatusEnum::PARTIALLY_RESOLVED
            ])
            ->filter(function ($item) {
                $deadlineAd = $this->bsToAd($item->action_deadline);
                return $deadlineAd < now();
            })
            ->count();

        $this->totalMultiYearOutStanding = $allBerujuEntries
            ->where('fiscal_year_id', $this->currentFiscalYearId)
            ->whereNotIn('status', [
                BerujuStatusEnum::RESOLVED,
                BerujuStatusEnum::PARTIALLY_RESOLVED
            ])
            ->filter(fn($item) => $this->bsToAd($item->action_deadline) < now()->subYears(2))
            ->count();

        $this->resolvedCount = $allBerujuEntries->whereIn('status', [
            BerujuStatusEnum::RESOLVED,
            BerujuStatusEnum::PARTIALLY_RESOLVED
        ])->where('fiscal_year_id', $this->currentFiscalYearId)
            ->count();

        $this->unresolvedCount = $allBerujuEntries->whereIn('status', [
            BerujuStatusEnum::DRAFT,
            BerujuStatusEnum::SUBMITTED,
            BerujuStatusEnum::ASSIGNED,
            BerujuStatusEnum::ACTION_TAKEN,
            BerujuStatusEnum::UNDER_REVIEW,
            BerujuStatusEnum::REJECTED_NOT_RESOLVED,
            BerujuStatusEnum::ARCHIVED,
        ])->where('fiscal_year_id', $this->currentFiscalYearId)
            ->count();

        // Get recent entries for the table
        $this->allBeruju =  $allBerujuEntries->sortByDesc('created_at')->where('fiscal_year_id', $this->currentFiscalYearId)->take(10);


        // Group by branch for current fiscal year
        $this->departmentBeruju = $allBerujuEntries
            ->where('fiscal_year_id', $this->currentFiscalYearId)
            ->groupBy('branch_id')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'branch_name' => $group->first()->branch?->title ?? 'Unknown Branch',
                ];
            });


        // Group by category for amount summary
        $this->berujuCategoryAmount = $allBerujuEntries
            ->whereNotNull('amount')
            ->where('fiscal_year_id', $this->currentFiscalYearId)
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
        $this->berujuByFiscalYear = $allBerujuEntries
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
    }

    public function updateFiscalYear()
    {
        $this->currentFiscalYearId = $this->selectedFiscalYear;
        $this->currentFiscalYear = FiscalYear::find($this->selectedFiscalYear)->year;
        $this->loadDashboardData();
        $this->dispatch('dashboardUpdated');
    }


    public function render()
    {
        return view('Beruju::livewire.dashboard');
    }
}
