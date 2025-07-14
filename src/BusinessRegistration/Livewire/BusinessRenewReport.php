<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;
use Src\BusinessRegistration\Exports\BusinessRegistrationRenewalReportExport;
use Src\BusinessRegistration\Exports\BusinessRegistrationReportExport;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Models\NatureOfBusiness;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\Employees\Models\Branch;
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

class BusinessRenewReport extends Component
{

    use SessionFlash, HelperDate, AdminSettings, WithPagination;


    public $startDate;
    public $endDate;
    public $applicationStatus;
    public $selectedApplicationStatus;

    // public $categories;
    // public $selectedCategory;
    // public $natures;
    // public $selectedNature;
    // public $wards;
    // public $selectedWard;

    // public $businessStatus;
    // public $selectedBusinessStatus;
    // public $types;
    // public $selectedType;


    public $renewalBusinessData;
    public $appliedFilters = [];

    public function rules(): array
    {
        return [
            'startDate' => ['required'],
            'endDate' => ['required'],
            'selectedApplicationStatus' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.report.renewal-report");
    }

    public function mount()
    {
        $this->applicationStatus = ApplicationStatusEnum::getForWebInNepali();
    }


    public function search()
    {
        $appliedFilters = [];

        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;

        $query = BusinessRenewal::with(['fiscalYear', 'registration', 'registration.province', 'registration.district', 'registration.localBody', 'registration.registrationType.registrationCategory'])->latest();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $appliedFilters[] = 'आवेदन मिति';
        }
        if ($this->selectedApplicationStatus) {
            $query->where('application_status', $this->selectedApplicationStatus);

            $appliedFilters[] = 'आवेदन स्थिति';
        }
        $this->appliedFilters = $appliedFilters;
        $this->renewalBusinessData = $query->get();
    }


    public function downloadPdf()
    {
        try {
            $renewalBusinessData =  $this->renewalBusinessData;
            $renewalBusinessData->load(['fiscalYear', 'registration', 'registration.province', 'registration.district', 'registration.localBody', 'registration.registrationType.registrationCategory']);

            $startDate = $this->startDate;
            $endDate = $this->endDate;
            if (empty($renewalBusinessData)) {
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
            $appliedFilters = $this->appliedFilters;
            $html = view('BusinessRegistration::livewire.report.pdf-renewal', compact('nepaliDate',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'renewalBusinessData', 'startDate', 'endDate', 'appliedFilters', 'user'))->render();

            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.BusinessRegistration.businessRegistration.pdf'),
                file_name: "businessRegistration" . date('YmdHis'),
                disk: "local",
            );

            return redirect()->away($url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }


    public function clear()
    {
        $this->startDate = null;
        $this->endDate = null;

        $this->renewalBusinessData = [];
    }

    public function export()
    {
        $renewalBusinessData =  $this->renewalBusinessData;
        $renewalBusinessData->load(['fiscalYear', 'registration', 'registration.province', 'registration.district', 'registration.localBody', 'registration.registrationType.registrationCategory']);

        if ($this->renewalBusinessData == null) {
            $this->errorToast(__("No Data Found"));
            return;
        }
        $exportFilePath = 'business-renewal-report.xlsx';
        return Excel::download(new BusinessRegistrationRenewalReportExport($renewalBusinessData), $exportFilePath);
    }
}
