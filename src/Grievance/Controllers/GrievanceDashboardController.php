<?php

namespace Src\Grievance\Controllers;

use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Http\Controllers\Controller;
use App\Services\FilterQueryService;
use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Maatwebsite\Excel\Facades\Excel;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Exports\GrievanceDetailExport;
use Src\Grievance\Exports\RecievedGrievanceExport;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceType;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;

class GrievanceDashboardController extends Controller implements HasMiddleware
{
    use HelperDate, AdminSettings;

    public static function middleware()
    {
        return [
            new Middleware('permission:grievance access', only: ['index']),
        ];
    }

    public function index()
    {
        try {

            [
                $grievancesTodayCount,
                $grievances,
                $grievancesUnseenCount,
                $grievancesInvestigatingCount,
                $grievancesClosedCount
            ] = Cache::remember('grievance_dashboard_data', now()->addMinutes(5), function () {
                // Execute queries sequentially instead of using Concurrency::run()
                $grievancesTodayCount = GrievanceDetail::whereDate('created_at', '=', now()->startOfDay()->toDateString())
                    ->count() ?? 0;
                $grievanceCount = GrievanceDetail::whereNull('deleted_at')->get() ?? 0;
                $grievancesUnseenCount = GrievanceDetail::where('status', GrievanceStatusEnum::UNSEEN)
                    ->count() ?? 0;
                $grievancesInvestigatingCount = GrievanceDetail::where('status', GrievanceStatusEnum::INVESTIGATING)
                    ->count() ?? 0;
                $grievancesClosedCount = GrievanceDetail::where('status', GrievanceStatusEnum::CLOSED)
                    ->count() ?? 0;
                    
                return [$grievancesTodayCount, $grievanceCount, $grievancesUnseenCount, $grievancesInvestigatingCount, $grievancesClosedCount];
            });
        } catch (\Exception $e) {
            Cache::forget('grievance_dashboard_data');
            return redirect()->route('admin.grievance.index');
        }

        $statuses = [GrievanceStatusEnum::UNSEEN, GrievanceStatusEnum::INVESTIGATING, GrievanceStatusEnum::CLOSED, GrievanceStatusEnum::REPLIED];
        $startOfWeek = Carbon::now()->locale('en')->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = $startOfWeek->copy()->addDays(6); // Moves till Friday

        // Fetch grievances created within the current week
        $grievancesDetails = $grievances->filter(function ($grievance) use ($startOfWeek, $endOfWeek) {
            return Carbon::parse($grievance->created_at)->between($startOfWeek, $endOfWeek);
        });

        // Group grievances by day of the week
        $groupedByDay = $grievancesDetails->groupBy(fn($grievance) => Carbon::parse($grievance->created_at)->dayOfWeek);

        // Prepare status counts for each day of the week
        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[$status->value] = array_fill(0, 7, 0);  // Initialize status counts for each day (0 for all days)
        }

        // Populate the status counts for each day
        foreach ($groupedByDay as $day => $grievancesOnDay) {
            foreach ($statuses as $status) {
                $statusCounts[$status->value][$day] = $grievancesOnDay->filter(fn($grievancesDetails) => $grievancesDetails->status == $status)->count();
            }
        }
        // Prepare data for Chart.js
        $labels = [__("Sunday"), __("Monday"), __("Tuesday"), __("Wednesday"), __("Thursday"), __("Friday"), __("Saturday")];
        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('Unseen'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'data' => $statusCounts[GrievanceStatusEnum::UNSEEN->value]
                ],
                [
                    'label' => __('Investigating'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'data' => $statusCounts[GrievanceStatusEnum::INVESTIGATING->value]
                ],
                [
                    'label' => __('Replied'),
                    'backgroundColor' => 'rgba(75, 19, 192, 0.5)',
                    'data' => $statusCounts[GrievanceStatusEnum::REPLIED->value]
                ],
                [
                    'label' => __('Closed'),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'data' => $statusCounts[GrievanceStatusEnum::CLOSED->value]
                ]
            ]
        ];

        $grievanceCount = $grievances->count() ?? 0;
        $grievanceChart = Cache::remember('grievance_chart', now()->addMinutes(5), function () use ($grievances) {
            return $grievances->groupBy('status')->map(function ($item) {
                return $item->count();
            });
        });

        return view('Grievance::dashboard', [
            'grievancesTodayCount' => $grievancesTodayCount,
            'grievanceCount' => $grievanceCount,
            'grievancesUnseenCount' => $grievancesUnseenCount,
            'grievancesInvestigatingCount' => $grievancesInvestigatingCount,
            'grievancesClosedCount' => $grievancesClosedCount,
            'grievanceChart' => $grievanceChart,
            'data' => $data,
            //            'statusCounts' => $statusCounts
        ]);
    }

    public function report(Request $request)
    {
        $user = Auth::user('web');
        $query = $this->initializeGrievanceQuery();
        $wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $grievanceType = GrievanceType::whereNull('deleted_at')->get();
        $fiscalYear = FiscalYear::whereNull('deleted_at')->get();

        if ($user->hasRole('super-admin')) {
            $query = $this->applyFilters($query, $request);
            $reports = $query->paginate(10);

            return view('Grievance::report.report', compact('reports', 'wards', 'grievanceType', 'fiscalYear'));
        }

        $this->applyUserFilters($query, $user);

        $query = $this->applyFilters($query, $request);

        // dd($query->get());
        $reports = $query->paginate(10);

        return view('Grievance::report.report', compact('reports', 'wards', 'grievanceType', 'fiscalYear'));
    }

    private function initializeGrievanceQuery()
    {
        return GrievanceDetail::query()
            ->with([
                'roles',
                'customer',
                'histories',
                'grievanceType',
                'records'
            ])
            ->whereNull(['grievance_detail_id', 'gri_grievance_details.deleted_at'])
            ->orderBy('gri_grievance_details.created_at', 'desc');
    }

    private function applyUserFilters($query, $user)
    {
        $userWardIds = $user->userWards()?->pluck('ward')->toArray();
        $userRoleIds = $user->roles?->pluck('id')->toArray();

        $service = new FilterQueryService();
        $query = $service->filterByWard($query, $userWardIds);
        $query = $service->filterByRole($query, $userRoleIds, 'roles');
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('filter_status')) {
            $query->where('status', $request->input('filter_status'));
        }

        if ($request->filled('filter_priority')) {
            $query->where('priority', $request->input('filter_priority'));
        }


        if ($request->filled('filter_ward')) {
            $query->where('ward_id', $request->input('filter_ward'));
        }

        if ($request->filled('filter_year')) {
            $query->where('fiscal_year_id', $request->input('filter_year'));
        }

        if ($request->filled('filter_type')) {
            $query->where('grievance_type_id', $request->input('filter_type'));
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $this->bsToAd($request->input('start_date'));
            $end_date = $this->bsToAd($request->input('end_date'));
            $startDate = Carbon::parse($start_date)->startOfDay();
            $endDate = Carbon::parse($end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('token', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('mobile_no', 'LIKE', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    public function AppliedGrievacereport(Request $request)
    {
        $user = Auth::user('web');
        $query = $this->initializeGrievanceQuery();

        if ($user->hasRole('super-admin')) {
            $query = $this->applyFilters($query, $request);
            $reports = $query->paginate(10);

            return view('Grievance::report.appliedGrievanceReport', compact('reports'));
        }

        $this->applyUserFilters($query, $user);

        $query = $this->applyFilters($query, $request);

        $reports = $query->paginate(10);

        return view('Grievance::report.appliedGrievanceReport', compact('reports'));
    }

    public function notification()
    {
        return view('Grievance::notification');
    }

    public function export(Request $request)
    {
        $query = $this->initializeGrievanceQuery();
        $query = $this->applyFilters($query, $request);
        $type = $request->input('type');
        $filteredData = $query->get();

        if ($type === 'report') {
            $exportFilePath = 'grievancereport.xlsx';
            return Excel::download(new GrievanceDetailExport($filteredData), $exportFilePath);
        } else {
            $exportFilePath = 'receivedgrievancereport.xlsx';
            return Excel::download(new RecievedGrievanceExport($filteredData), $exportFilePath);
        }
    }


    // public function downloadPdf(Request $request)
    // {
    //     ini_set('pcre.backtrack_limit', '10000000');
    //     $query = $this->applyFilters($this->initializeGrievanceQuery(), $request);
    //     $reports = $query->get();
    //     $filters = $this->getFilters($request);
    //     $user = Auth::user();

    //     foreach ($reports as $report) {
    //         $bsDate = $this->adToBs($report->created_at);
    //         $report->nepali_created_at = $this->convertEnglishToNepali($bsDate);
    //     }
    //     $ward = Ward::where('id', GlobalFacade::ward())->first();
    //     $palika_name = $this->getConstant('palika-name');
    //     $palika_logo = $this->getConstant('palika-logo');
    //     $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

    //     $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
    //     $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office-name');
    //     $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

    //     $html = view('Grievance::grievance-pdf', compact('nepaliDate', 'filters', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports'))->render();

    //     $chunks = str_split($html, 1000000);

    //     $pdfContent = '';
    //     foreach ($chunks as $chunk) {
    //         $pdfContent .= $chunk;
    //     }

    //     return redirect()->away(PdfFacade::saveAndStream(
    //         content: $pdfContent,
    //         file_path: config('src.Recommendation.recommendation.certificate'),
    //         file_name: "register_file_{$user->email}" . date('YmdHis'),
    //         disk: "local",
    //     ));
    // }

    public function downloadPdf(Request $request)
    {
        ini_set('pcre.backtrack_limit', '10000000');
        $query = $this->applyFilters($this->initializeGrievanceQuery(), $request);
        $reports = $query->get();
        $filters = $this->getFilters($request);
        $user = Auth::user();
        foreach ($reports as $report) {
            $bsDate = $this->adToBs($report->created_at);
            $report->nepali_created_at = $this->convertEnglishToNepali($bsDate);
        }
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office-name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        $html = view('Grievance::grievance-pdf', compact('nepaliDate', 'filters', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.Recommendation.recommendation.certificate'),
            file_name: "register_file_{$user->email}" . date('YmdHis'),
            disk: "local",
        ));
    }

    /**
     * Extract and format filters from request.
     */
    private function getFilters(Request $request)
    {
        $allFilters = [
            'filter_status' => __('Status'),
            'filter_ward' => __('Ward'),
            'filter_recommendation' => __('Recommendation'),
            'filter_recommendationCategory' => __('Recommendation Category'),
            'filter_priority' => __('Priority'),
            'start_date' => __('Start Date'),
            'end_date' => __('End Date'),
            'search' => __('Search')
        ];

        return collect($allFilters)->filter(fn($label, $key) => $request->filled($key))
            ->mapWithKeys(fn($label, $key) => [$key => ['label' => $label, 'value' => $request->input($key)]])
            ->toArray();
    }
}
