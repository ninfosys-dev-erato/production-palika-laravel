<?php

namespace Src\Ebps\Livewire;

use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\BuildingStructureEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Exports\EbpsReportExport;
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Models\MapApply;
use Src\Wards\Models\Ward;
use Src\Settings\Traits\AdminSettings;

class EbpsReport extends Component
{

    use SessionFlash, HelperDate, AdminSettings;

    public $startDate;
    public $endDate;
    public $mapApplyData;
    public $usageOptions;
    public $buildingStructures;
    public $selectedApplicationType;
    public $applicationTypes;
    public $wards;
    public $selectedWard;
    public $selectedConstructionType;
    public bool $oldApplication = false;
    public $constructionTypes;
    public $selectedUsage;
    public $selectedBuildingStructure;

    public $appliedFilters = [];


    public function rules(): array
    {
        return [
            'startDate' => ['nullable'],
            'endDate' => ['nullable'],
            'selectedWard' => ['nullable'],
         
        ];
    }

    public function render()
    {
        return view("Ebps::livewire.report");
    }

    public function mount()
    {
        $this->usageOptions = PurposeOfConstructionEnum::cases();
        if (is_null($this->selectedApplicationType)) {
        $this->selectedApplicationType  = ApplicationTypeEnum::MAP_APPLIES->value;
        $this->buildingStructures = BuildingStructureEnum::cases();
    }
        $this->applicationTypes = ApplicationTypeEnum::cases();
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $this->constructionTypes = ConstructionType::whereNull('deleted_at')->get();
    }

    public function updateType()
    {
        if($this->selectedApplicationType == ApplicationTypeEnum::OLD_APPLICATIONS->value){
            $this->oldApplication = !$this->oldApplication;
        }
    }

    public function search()
    {
        $appliedFilters = [];
        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;

        $query = MapApply::with([
            'fiscalYear',
            'localBody',
            'constructionType'
        ])->latest();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
             $appliedFilters[] = 'आवेदन मिति';
        }

        
        if (!empty($this->selectedApplicationType)) {
            $query->where('application_type', $this->selectedApplicationType);
             $appliedFilters[] = 'आवेदनको प्रकार';
         
        }
        if (!empty($this->selectedWards)) {
            $query->whereIn('ward_no', $this->selectedWards);
            $appliedFilters[] = 'वडा';
        }
        if (!empty($this->selectedConstructionType)) {
            $query->where('construction_type_id', $this->selectedConstructionType);
             $appliedFilters[] = 'निर्माणको प्रकार';
        }

        if(!empty($this->selectedUsage))
        {
            $query->where('usage', $this->selectedUsage);
            $appliedFilters[] = 'प्रयोग';
        }
        
        if(!empty($this->selectedBuildingStructure))
        {
            $query->where('building_structure', $this->selectedBuildingStructure);
            $appliedFilters[] = 'भवन संरचना';
        }

        $this->mapApplyData = $query->get();

        foreach ($this->mapApplyData as $registerData) {
            $registerData->created_at_bs = replaceNumbers(
                $this->adToBs($registerData->created_at->format('Y-m-d')),
                true
            );
        }
    }

    public function clear()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedApplicationType = null;
        $this->selectedWard = null;
        $this->oldApplication = !$this->oldApplication;
       
    }

    public function export()
    {
        if ($this->mapApplyData == null) {
            $this->errorToast(__('ebps::ebps.no_data_found'));
            return;
        }
        $exportFilePath = 'ebps-report.xlsx';
        return Excel::download(
            new EbpsReportExport($this->mapApplyData, $this->selectedApplicationType),
            $exportFilePath
        );
    }

     public function downloadPdf()
    {
        try {
            $selectedApplicationType = $this->selectedApplicationType;
            $mapApplyData =  $this->mapApplyData;
            $mapApplyData->load(['fiscalYear',
            'localBody',
            'constructionType']); //explicitly loaded this relation to fix the error of lazy loading
            $startDate = $this->startDate;
            $endDate = $this->endDate;
            if (empty($mapApplyData)) {
                $this->errorToast(__('ebps::ebps.no_data_found'));
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
            $html = view('Ebps::livewire.pdf', compact('nepaliDate',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'mapApplyData', 'startDate', 'endDate', 'appliedFilters', 'user', 'selectedApplicationType'))->render();

         
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Ebps.ebps.pdf'),
                file_name: "ebps" . date('YmdHis'),
                disk: getStorageDisk('private'),
            );

         $this->dispatch('open-pdf', url: $url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
}
