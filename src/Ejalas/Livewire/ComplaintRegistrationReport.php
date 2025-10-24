<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\ComplaintRegistrationAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Models\DisputeMatter;
use Src\Ejalas\Models\Priotity;
use Src\Ejalas\Service\ComplaintRegistrationAdminService;
use Src\Ejalas\Service\ReportAdminService;
use Src\FiscalYears\Models\FiscalYear;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Src\Wards\Models\Ward;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperTemplate;
use Src\Settings\Traits\AdminSettings;
use Carbon\Carbon;
use Src\Ejalas\Enum\ApplicationStatus;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\Ejalas\Models\ReconciliationCenter;

class ComplaintRegistrationReport extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;
    public $startDate;
    public $endDate;
    public $disputeMatters;
    public $disputeAreas;
    public $allStatus;
    public $regAddresses;
    public $fiscalYears;

    public $wards;


    public $selectedStatus = null;
    public $selectedDisputeMatter;
    public $selectedDisputeArea;
    public $selectedReconciliationCenter;
    public $selectedWard;
    public $selectedRegAddress;
    public $complaints = [];
    public  $nepaliDate;
    public $letterHead;
    public $selectedFiscalYear;


    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required',
        'selectedStatus' => 'nullable',
        'selectedDisputeMatter' => 'nullable',
        'selectedDisputeArea' => 'nullable',
        'selectedWard' => 'nullable',
        'selectedRegAddress' => 'nullable'
    ];

    public function render()
    {

        return view("Ejalas::livewire.complaint-registration.report");
    }

    public function mount()
    {
        $this->disputeMatters = DisputeMatter::whereNull('deleted_at')->pluck('title', 'id');
        $this->disputeAreas = DisputeArea::whereNull('deleted_at')->pluck('title', 'id');
        $this->regAddresses = PlaceOfRegistration::getValuesWithLabels();
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $this->allStatus = ApplicationStatus::getValuesWithLabels();
        $this->nepaliDate =  $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $this->letterHead =  $this->getBusinessLetterHeaderFromSample();
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
    }

    public function searchReport()
    {
        $this->validate();

        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->complaints = ComplaintRegistration::with([
            'fiscalYear',
            'priority',
            'disputeMatter',
            'parties',
            'disputeMatter.disputeArea'
        ])
            ->whereNull('jms_complaint_registrations.deleted_at')
            ->whereNull('jms_complaint_registrations.deleted_by')
            ->whereBetween('reg_date_en', [$startDate, $endDate])
            ->when($this->selectedFiscalYear, function ($query) {
                $query->where('fiscal_year_id', $this->selectedFiscalYear);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->when($this->selectedWard, function ($query) {
                $query->where('ward_no', $this->selectedWard);
            })
            ->when($this->selectedDisputeMatter, function ($query) {
                $query->where('dispute_matter_id', $this->selectedDisputeMatter);
            })
            ->when($this->selectedDisputeArea, function ($query) {
                $query->whereHas('disputeMatter', function ($q) {
                    $q->where('dispute_area_id', $this->selectedDisputeArea);
                });
            })
            ->when($this->selectedRegAddress, function ($query) {
                $query->where('reg_address', $this->selectedRegAddress);
            })
            ->orderBy('jms_complaint_registrations.created_at', 'DESC')
            ->get();
    }


    // $selectedStatus = $this->selectedStatus;
    // $selectedDisputeMatter = $this->selectedDisputeMatter;
    // $selectedDisputeArea = $this->selectedDisputeArea;
    // $selectedReconciliationCenter = $this->selectedReconciliationCenter;
    // $selectedWard = $this->selectedWard;

    // $this->dispatch('getSearchDate', $startDate, $endDate, $selectedStatus, $selectedDisputeMatter, $selectedDisputeArea, $selectedReconciliationCenter, $selectedWard);

    public function downloadPdf()
    {
        if (empty($this->complaints)) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
    public function clear()
    {
        $this->reset([
            'selectedStatus',
            'selectedDisputeMatter',
            'selectedDisputeArea',
            'selectedWard',
            'startDate',
            'endDate',
        ]);
        $this->dispatch('getSearchDate', null, null, null, null, null, null, null);
    }
}
