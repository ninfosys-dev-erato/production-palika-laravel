<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Src\Employees\Models\Branch;
use Src\Settings\Models\FiscalYear;
use Src\TokenTracking\Exports\TokenReportExport;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Enums\TokenStageEnum;
use Src\TokenTracking\Enums\TokenStatusEnum;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\RegisterTokenAdminService;
use Src\Wards\Models\Ward;
use Src\Settings\Traits\AdminSettings;
use Src\TokenTracking\Enums\CitizenSatisfactionEnum;
use Src\TokenTracking\Enums\ServiceAccesibilityEnum;
use Src\TokenTracking\Enums\ServiceQualityEnum;
use Src\TokenTracking\Enums\TokenPurposeEnum;
use Livewire\Attributes\On;
use App\Models\User;

class ReportTokenForm extends Component
{

    use SessionFlash, HelperDate, AdminSettings;

    public $startDate;
    public $endDate;
    public $departments;
    public array $selectedDepartment = [];

    public $registerTokenData;
    public $selectedStatus;
    public $selectedStage;
    public $status;
    public $stage;
    public $selectedPurpose;
    public $purpose;
    public $citizenSatisfaction;
    public $serviceAccesibility;
    public $serviceQuality;
    public $selectedCitizen;
    public $selectedAccessibility;
    public $selectedQuality;


    public $token;
    public $customer;


    public $tokenHolder;

    public $selectedTokenId;

    public $fiscalYears;
    public $selectedSignee;




    public function rules(): array
    {
        return [
            'startDate' => ['nullable'],
            'endDate' => ['nullable'],
            'departments' => ['nullable'],
            'selectedStatus' => ['nullable'],
            'selectedStage' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("TokenTracking::livewire.report-token-form");
    }

    public function mount()
    {
        $this->departments = Branch::whereNull('deleted_at')->pluck('title_en', 'id');
        $this->stage = TokenStageEnum::getValuesWithLabels();
        $this->status = TokenStatusEnum::getValuesWithLabels();
        $this->purpose = TokenPurposeEnum::getValuesWithLabels();
        $this->citizenSatisfaction = CitizenSatisfactionEnum::getValuesWithLabels();
        $this->serviceAccesibility = ServiceAccesibilityEnum::getValuesWithLabels();
        $this->serviceQuality = ServiceQualityEnum::getValuesWithLabels();
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
    }


    public function search()
    {
        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;

        $query = RegisterToken::with([
            'tokenHolder',
            'feedback' => function ($query) {
                $query->latest()->limit(1);
            },
            'currentBranch'
        ])->latest();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $query->whereDate('created_at', today());
        }

        if (!empty($this->selectedDepartment)) {
            $query->whereIn('current_branch', $this->selectedDepartment);
        }
        if ($this->selectedStage) {
            $query->where('stage', $this->selectedStage);
        }
        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }

        if ($this->selectedPurpose) {
            $query->where('token_purpose', $this->selectedPurpose);
        }
        if ($this->selectedCitizen) {
            $query->whereHas('feedback', function ($q) {
                $q->where('citizen_satisfaction', $this->selectedCitizen);
            });
        }
        if ($this->selectedAccessibility) {
            $query->whereHas('feedback', function ($q) {
                $q->where('service_accesibility', $this->selectedAccessibility);
            });
        }
        if ($this->selectedQuality) {
            $query->whereHas('feedback', function ($q) {
                $q->where('service_quality', $this->selectedQuality);
            });
        }
        $this->registerTokenData = $query->get();



        foreach ($this->registerTokenData as $registerToken) {  //converted english date to nepali
            $registerToken->created_at_bs = replaceNumbers(
                $this->adToBs($registerToken->created_at->format('Y-m-d')),
                true
            );
        }
    }

    public function clear()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedDepartment = [];
        $this->registerTokenData = [];
        $this->selectedStage = null;
        $this->selectedStatus = null;
    }


    public function export()
    {
        if ($this->registerTokenData == null) {
            $this->errorToast(__("tokentracking::tokentracking.no_data_found"));
            return;
        }
        $exportFilePath = 'token-report.xlsx';
        return Excel::download(new TokenReportExport($this->registerTokenData), $exportFilePath);
    }

    public function downloadPdf()
    {
        $reports = $this->registerTokenData;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        if ($reports == null) {
            $this->errorToast(__("tokentracking::tokentracking.no_data_found"));
            return;
        }
        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        foreach ($reports as $registerToken) {  //converted english date to nepali
            $registerToken->created_at_bs = replaceNumbers(
                $this->adToBs($registerToken->created_at->format('Y-m-d')),
                true
            );
        }

        $html = view('TokenTracking::pdf', compact('nepaliDate',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.TokenTracking.tokentracking.certificate'),
            file_name: "token_{$user->email}" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }
    #[On('signee-selected')]
    public function setSignee(User $signee)
    {
        $this->selectedSignee = $signee;
        // dd($this->selectedSignee);
    }
    public function branchCountPdf()
    {
        $reports = empty($this->registerTokenData)
            ? collect()
            : $this->registerTokenData
            ->groupBy('current_branch')
            ->map(function ($tokens, $branchId) {
                return [
                    'branch_id' => $branchId,
                    'branch_name' => $tokens->first()->currentBranch?->title ?? 'N/A',
                    'total_tokens' => $tokens->count(),
                ];
            });
        $totalTokens = $reports->sum('total_tokens'); //get total token count in here to show at the end of the table
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $signee = $this->selectedSignee;
        if ($reports->isEmpty()) {
            $this->errorToast(__("No Data Found"));
            return;
        }
        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $palika_office = getSetting('office-name');


        $html = view('TokenTracking::branchCountPdf', compact('nepaliDate',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate', 'totalTokens', 'signee', 'palika_office'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.TokenTracking.tokentracking.certificate'),
            file_name: "token_{$user->email}" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }
    public function branchPurposeCountPdf()
    {

        $reports = empty($this->registerTokenData)
            ? collect()
            : $this->registerTokenData
            ->groupBy('current_branch')
            ->map(function ($tokens, $branchId) {
                return [
                    'branch_id' => $branchId,
                    'branch_name' => $tokens->first()->currentBranch?->title ?? 'Unknown Branch',
                    'purposes' => $tokens->groupBy('token_purpose')->map(function ($purposeTokens, $purpose) {
                        return [
                            'purpose' => TokenPurposeEnum::getLabel(TokenPurposeEnum::from($purpose)),

                            'total_tokens' => $purposeTokens->count(),
                        ];
                    })->values(),
                ];
            });
        $totalTokens = $reports->flatMap(function ($report) {
            return $report['purposes'];
        })->sum('total_tokens'); //get total token count in here to show at the end of the table
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $signee = $this->selectedSignee;

        if ($reports->isEmpty()) {
            $this->errorToast(__("No Data Found"));
            return;
        }

        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');
        $palika_office = getSetting('office-name');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        $html = view('TokenTracking::branchPurposeCountPdf', compact('nepaliDate',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate', 'totalTokens', 'signee', 'palika_office'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.TokenTracking.tokentracking.certificate'),
            file_name: "token_{$user->email}" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }
}
