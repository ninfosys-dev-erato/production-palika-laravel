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
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
use Src\BusinessRegistration\Exports\BusinessRegistrationRenewalReportExport;
use Src\BusinessRegistration\Exports\BusinessRegistrationReportExport;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Models\NatureOfBusiness;
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
    public $categories;
    public $selectedCategory;
    public $natures;
    public $selectedNature;
    public $wards;
    public $selectedWard;
    public $businessStatus;
    public $selectedBusinessStatus;
    public $types;
    public $selectedType;

    public $renewalBusinessData;
    public $appliedFilters = [];

    public function rules(): array
    {
        return [
            'startDate' => ['required'],
            'endDate' => ['required'],
            'selectedCategory' => ['nullable'],
            'selectedNature' => ['nullable'],
            'selectedWard' => ['nullable'],
            'selectedApplicationStatus' => ['nullable'],
            'selectedBusinessStatus' => ['nullable'],
            'selectedType' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.report.renewal-report");
    }

    public function mount()
    {
        $this->categories = RegistrationCategoryEnum::getForWebInNepali();
        $this->natures = NatureOfBusiness::whereNull('deleted_at')->pluck('title', 'id');
        $this->types = RegistrationType::whereNull('deleted_at')->pluck('title', 'id');
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $this->applicationStatus = ApplicationStatusEnum::getForWebInNepali();
        $this->businessStatus = BusinessStatusEnum::getForWebInNepali();
    }


    public function search()
    {
        // Prepare an array to store applied filters with Nepali variable names
        $appliedFilters = [];

        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;

        $query = BusinessRenewal::with([
            'fiscalYear',
            'registration',
            'registration.businessProvince',
            'registration.businessDistrict',
            'registration.businessLocalBody',
            'registration.registrationType.registrationCategory',
            'registration.applicants.applicantProvince',
            'registration.applicants.applicantDistrict',
            'registration.applicants.applicantLocalBody'
        ])->latest();

        // Apply filters to the query and add them to the applied filters array
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $appliedFilters[] = 'आवेदन मिति';
        }
        if ($this->selectedCategory) {
            $query->whereHas('registration', function ($q) {
                $q->where('registration_category', $this->selectedCategory);
            });
            $appliedFilters[] = 'वर्ग';
        }
        if ($this->selectedType) {
            $query->whereHas('registration', function ($q) {
                $q->where('registration_type_id', $this->selectedType);
            });
            $appliedFilters[] = 'दर्ता प्रकार';
        }
        if ($this->selectedNature) {
            $query->whereHas('registration', function ($q) {
                $q->where('business_nature', $this->selectedNature);
            });
            $appliedFilters[] = 'व्यवसाय प्रकृति';
        }
        if ($this->selectedWard) {
            $query->whereHas('registration', function ($q) {
                $q->where('business_ward', $this->selectedWard);
            });
            $appliedFilters[] = 'वडा नं.';
        }
        if ($this->selectedApplicationStatus) {
            $query->where('application_status', $this->selectedApplicationStatus);
            $appliedFilters[] = 'आवेदन स्थिति';
        }
        if ($this->selectedBusinessStatus) {
            $query->whereHas('registration', function ($q) {
                $q->where('business_status', $this->selectedBusinessStatus);
            });
            $appliedFilters[] = 'व्यवसाय स्थिति';
        }

        $this->appliedFilters = $appliedFilters;
        $this->renewalBusinessData = $query->get();
    }


    public function downloadPdf()
    {
        try {
            $renewalBusinessData =  $this->renewalBusinessData;
            $renewalBusinessData->load([
                'fiscalYear',
                'registration',
                'registration.businessProvince',
                'registration.businessDistrict',
                'registration.businessLocalBody',
                'registration.registrationType.registrationCategory',
                'registration.applicants.applicantProvince',
                'registration.applicants.applicantDistrict',
                'registration.applicants.applicantLocalBody'
            ]);

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
                file_name: "businessRenewal" . date('YmdHis'),
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
        $this->selectedCategory = null;
        $this->selectedNature = null;
        $this->selectedWard = null;
        $this->selectedApplicationStatus = null;
        $this->selectedBusinessStatus = null;
        $this->selectedType = null;
        $this->renewalBusinessData = [];
        $this->appliedFilters = [];
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
