<?php

namespace Src\Recommendation\Controllers;

use App\Enums\Action;
use App\Facades\FileTrackingFacade;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Http\Controllers\Controller;
use App\Services\FilterQueryService;
use App\Traits\ApiStandardResponse;
use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Customers\Models\Customer;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Exports\RecommendationReportExport;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationService;
use Src\Recommendation\Traits\RecommendationTemplate;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;

class ApplyRecommendationController extends Controller implements HasMiddleware
{
    use ApiStandardResponse, HelperDate, AdminSettings, RecommendationTemplate;

    public static function middleware()
    {
        return [
            new Middleware('permission:recommendation_apply access', only: ['index']),
            new Middleware('permission:recommendation_apply create', only: ['create']),
            new Middleware('permission:recommendation_apply update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Recommendation::apply-recommendation.index');
    }

    function create(Recommendation $recommendation)
    {
        $action = Action::CREATE;
        $isModalForm = true;
        return view('Recommendation::apply-recommendation.form')->with(compact(['action', 'isModalForm', 'recommendation']));
    }

    function edit(Request $request)
    {
        $applyRecommendation = ApplyRecommendation::find($request->route('id'));
        $applyRecommendation->data = json_decode($applyRecommendation->data, true, 512);
        $action = Action::UPDATE;
        return view('Recommendation::apply-recommendation.form')->with(compact('action', 'applyRecommendation'));
    }

    public function show(int $id)
    {
        $applyRecommendation = ApplyRecommendation::with([
            'customer',
            'form',
            'recommendation'
        ])
            ->findOrFail($id);
        $revenue = $applyRecommendation->recommendation?->revenue ?? 0;
        $showBillUpload = $applyRecommendation->status == RecommendationStatusEnum::SENT_FOR_PAYMENT;
        return view('Recommendation::apply-recommendation.show', compact('applyRecommendation', 'showBillUpload', 'revenue'));
    }

   public function search(Request $request): JsonResponse
    {
        $ward = $request->get('ward');
        $user = Auth::id();
    
        $query = QueryBuilder::for(Customer::class)
            ->where(function ($q) use ($ward, $user) {
                $q->where(function ($subQ) use ($ward) {
                    $subQ->whereNotNull('kyc_verified_at')
                        ->whereHas('kyc', function ($kycQ) use ($ward) {
                            $kycQ->where('permanent_ward', $ward);
                        });
                })->orWhere('created_by', $user);
            })
            ->allowedFilters([
                'name',
                'mobile_no',
            ])
            ->paginate(50)
            ->appends(request()->query());
            
        return $this->generalSuccess([
            'data' => $query->items()
        ]);
    }

    public function report(Request $request)
    {
        $user = Auth::user('web');
        $query = $this->initializeGrievanceQuery();

        $wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $recommendation = Recommendation::whereNull('deleted_at')->whereNull('deleted_by')->get();
        $recommendationCategory = RecommendationCategory::whereNull('deleted_at')->whereNull('deleted_by')->get();
        $fiscalYear = FiscalYear::whereNull('deleted_by')->get();

        if ($user->hasRole('super-admin')) {
            $query = $this->applyFilters($query, $request);
            $reports = $query->paginate(10);
            return view("Recommendation::report.report", compact('reports', 'wards', 'recommendation', 'recommendationCategory', 'fiscalYear'));
        }

        $this->applyUserFilters($query, $user);

        $query = $this->applyFilters($query, $request);

        $reports = $query->paginate(10);

        return view("Recommendation::report.report", compact('reports', 'wards', 'recommendation', 'recommendationCategory', 'fiscalYear'));
    }

    private function initializeGrievanceQuery()
    {
        return ApplyRecommendation::query()
            ->with([
                'customer',
                'recommendation.recommendationCategory',
                'records'

            ])
            ->whereNull(['rec_apply_recommendations.deleted_at'])
            ->orderBy('rec_apply_recommendations.created_at', 'desc');
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

        if ($request->filled('filter_ward')) {
            $query->where('ward_id', $request->input('filter_ward'));
        }
        if ($request->filled('filter_year')) {
            $query->where('fiscal_year_id', $request->input('filter_year'));
        }

        if ($request->filled('filter_recommendation')) {
            $query->where('recommendation_id', $request->input('filter_recommendation'));
        }

        if ($request->filled('filter_recommendationCategory')) {
            $categoryId = $request->input('filter_recommendationCategory');
            $query->whereHas('recommendation', function ($q) use ($categoryId) {
                $q->where('recommendation_category_id', $categoryId);
            });
        }

        if ($request->filled('filter_priority')) {
            $query->where('priority', $request->input('filter_priority'));
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
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_no', 'LIKE', "%{$search}%");
            });
        }


        return $query;
    }

    public function export(Request $request)
    {
        $query = $this->initializeGrievanceQuery();

        $query = $this->applyFilters($query, $request);

        $filteredData = $query->get();

        $exportFilePath = 'recommendationreport.xlsx';
        return Excel::download(new RecommendationReportExport($filteredData), $exportFilePath);
    }

    public function register(int $id)
    {
        $recommendation = ApplyRecommendation::with('recommendation')->where('id', $id)->first();
        FileTrackingFacade::recordFile($recommendation, register: $register = true);
        return redirect()->route('admin.recommendations.apply-recommendation.show', $id);
    }


    public function downloadPdf(Request $request)
    {
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

        $html = view('Recommendation::recommendation-pdf', compact('nepaliDate', 'filters', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports'))->render();
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

    public function preview($id)
    {
        $applyRecommendation = ApplyRecommendation::where('id', $id)->first();
        $template = $this->resolveRecommendationTemplate($applyRecommendation);

        return view('Recommendation::apply-recommendation.preview')->with(compact('template', 'applyRecommendation'));
    }
}
