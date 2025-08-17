<?php

namespace Src\FileTracking\Controllers;

use App\Enums\Action;
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
use Src\FileTracking\Exports\ChalaniExport;
use Src\FileTracking\Models\FileRecord;
use Maatwebsite\Excel\Facades\Excel;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;

class ChalaniAdminController extends Controller implements HasMiddleware
{
    use HelperDate, AdminSettings;

    public static function middleware()
    {
        return [
            new Middleware('permission:chalani access', only: ['index']),
            new Middleware('permission:chalani create', only: ['create']),
            new Middleware('permission:chalani update', only: ['edit']),
        ];
    }


    function index(Request $request)
    {
        return view('FileTracking::chalani.chalani-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FileTracking::chalani.chalani-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $fileRecord = FileRecord::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FileTracking::chalani.chalani-form')->with(compact('action', 'fileRecord'));
    }

    public function report(Request $request)
    {
        $user = Auth::user('web');

        $query = FileRecord::with(['sender', 'departments', 'fiscalYear'])
            ->whereNotNull('reg_no')
            ->whereNull('deleted_at')
            ->where('is_chalani', true)
            ->whereNull('deleted_by')
            ->orderBy('reg_no', 'DESC')
            ->orderBy('created_at', 'DESC');


        $wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);

        $fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $currentFiscalYearId =  key(getSettingWithKey('fiscal-year'));

        if (!$request->has('fiscal_year') || empty($request->fiscal_year)) {
            $query->where('fiscal_year', $currentFiscalYearId);
            $request->merge(['fiscal_year' => $currentFiscalYearId]); // for blade auto selection
        }

        if ($user->hasRole('super-admin')) {
            $query = $this->applyFilters($query, $request);
            $reports = $query->paginate(10);

            return view('FileTracking::report.chalani-report', compact('reports', 'wards', 'fiscalYears'));
        }

        $departmentId = GlobalFacade::department();
        $ward = GlobalFacade::ward();

          if (!$user->hasRole('super-admin')) {
            // If both are missing, deny access
            if (!$departmentId && !$ward) {
                return $query->where('id', -1); // No match
            }

            // Apply available filters
            if ($departmentId) {
                $query->where('branch_id', $departmentId);
            }

            if ($ward) {
                $query->where('ward', $ward);
            }
          }
        $query = $this->applyFilters($query, $request);

        $reports = $query->paginate(10);

        return view('FileTracking::report.chalani-report', compact('reports', 'wards', 'fiscalYears'));
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

        if ($request->filled('filter_ward')) {
            $query->where('ward', $request->input('filter_ward'));
        }

        if ($request->filled('fiscal_year')) {
            $query->where('fiscal_year', $request->input('fiscal_year'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $this->bsToAd($request->input('start_date'));
            $end_date = $this->bsToAd($request->input('end_date'));
            $startDate = Carbon::parse($start_date)->startOfDay();
            $endDate = Carbon::parse($end_date)->endOfDay();
            $query->whereBetween('registration_date', [$startDate, $endDate]);
        }


        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name', 'LIKE', "%{$search}%")
                    ->orWhere('applicant_mobile_no', 'LIKE', "%{$search}%")
                    ->orWhere('applicant_address', 'LIKE', "%{$search}%")
                    ->orWhere('recipient_position', 'LIKE', "%{$search}%")
                    ->orWhere('recipient_name', 'LIKE', "%{$search}%")
                    ->orWhere('recipient_department', 'LIKE', "%{$search}%")
                    ->orWhere('signee_position', 'LIKE', "%{$search}%")
                    ->orWhere('signee_name', 'LIKE', "%{$search}%")
                    ->orWhere('signee_department', 'LIKE', "%{$search}%");
            });
        }

        return $query;
    }

    public function export(Request $request)
    {
        $query =  FileRecord::with('departments')->whereNotNull('reg_no')
            ->whereNull('deleted_at')
            ->where('is_chalani', true)
            ->whereNull('deleted_by');
        $query = $this->applyFilters($query, $request);
        $filteredData = $query->get();

        $exportFilePath = 'chalani-report.xlsx';
        return Excel::download(new ChalaniExport($filteredData), $exportFilePath);
    }

    public function initializeQuery()
    {

        return FileRecord::with(['departments', 'sender'])->whereNotNull('reg_no')
            ->whereNull('deleted_at')
            ->where('is_chalani', true)
            ->whereNull('deleted_by');
    }

    public function downloadPdf(Request $request)
    {
        $query = $this->applyFilters($this->initializeQuery(), $request);
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
        $palika_ward = $ward->ward_name_ne;
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        $html = view('FileTracking::chalani.chalani-pdf', compact('nepaliDate', 'filters', 'reports', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.Recommendation.recommendation.certificate'),
            file_name: "chalani_{$user->email}" . date('YmdHis'),
            disk: "local",
        ));
    }

    private function getFilters(Request $request)
    {
        $allFilters = [
            'filter_ward' => __('Ward'),

            'start_date' => __('Start Date'),
            'end_date' => __('End Date'),
            'search' => __('Search')
        ];

        return collect($allFilters)->filter(fn($label, $key) => $request->filled($key))
            ->mapWithKeys(fn($label, $key) => [$key => ['label' => $label, 'value' => $request->input($key)]])
            ->toArray();
    }
}
