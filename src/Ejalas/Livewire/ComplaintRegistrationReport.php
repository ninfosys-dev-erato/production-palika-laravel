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
use Src\Settings\Traits\AdminSettings;
use Carbon\Carbon;
use Src\Ejalas\Models\ReconciliationCenter;

class ComplaintRegistrationReport extends Component
{
    use SessionFlash, HelperDate, AdminSettings;
    public $startDate;
    public $endDate;
    public $disputeMatters;
    public $disputeAreas;
    public $reconciliationCenters;
    public $wards;

    public $selectedStatus = null;
    public $selectedDisputeMatter;
    public $selectedDisputeArea;
    public $selectedReconciliationCenter;
    public $selectedWard;
    public $complaints = [];


    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required',
        'selectedStatus' => 'nullable',
        'selectedDisputeMatter' => 'nullable',
        'selectedDisputeArea' => 'nullable',
        'selectedWard' => 'nullable',
    ];

    public function render()
    {

        return view("Ejalas::livewire.complaint-registration.report");
    }

    public function mount()
    {
        $this->disputeMatters = DisputeMatter::whereNull('deleted_at')->pluck('title', 'id');
        $this->disputeAreas = DisputeArea::whereNull('deleted_at')->pluck('title', 'id');
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->complaints = ComplaintRegistration::with(['fiscalYear', 'priority', 'disputeMatter', 'parties', 'disputeMatter.disputeArea'])
            ->where('jms_complaint_registrations.deleted_at', null)
            ->where('jms_complaint_registrations.deleted_by', null)
            ->orderBy('jms_complaint_registrations.created_at', 'DESC')
            ->whereBetween('reg_date', [$startDate, $endDate])
            ->when(!$this->selectedReconciliationCenter, function ($query) {
                $query->whereNull('reconciliation_center_id');
            })
            ->when(true, function ($query) {
                if ($this->selectedStatus === 'pending') {
                    $query->whereNull('status');
                } elseif ($this->selectedStatus === '0' || $this->selectedStatus === '1') {
                    $query->where('status', $this->status);
                }
                $query->when($this->selectedWard, function ($query) {
                    $query->where('ward_no', $this->selectedWard);
                });

                $query->when($this->selectedDisputeMatter, function ($query) {
                    $query->where('dispute_matter_id', $this->selectedDisputeMatter);
                });

                $query->when($this->selectedDisputeArea, function ($query) {
                    $query->whereHas('disputeMatter', function ($q) {
                        $q->where('dispute_area_id', $this->selectedDisputeArea);
                    });
                });

                $query->when($this->selectedReconciliationCenter, function ($query) {
                    $query->where('reconciliation_center_id', $this->selectedReconciliationCenter);
                });
            })
            ->get();

        // $selectedStatus = $this->selectedStatus;
        // $selectedDisputeMatter = $this->selectedDisputeMatter;
        // $selectedDisputeArea = $this->selectedDisputeArea;
        // $selectedReconciliationCenter = $this->selectedReconciliationCenter;
        // $selectedWard = $this->selectedWard;

        // $this->dispatch('getSearchDate', $startDate, $endDate, $selectedStatus, $selectedDisputeMatter, $selectedDisputeArea, $selectedReconciliationCenter, $selectedWard);
    }
    public function downloadPdf()
    {
        $this->validate();

        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $complaints = ComplaintRegistration::with(['fiscalYear', 'priority', 'disputeMatter', 'parties', 'disputeMatter.disputeArea'])
            ->where('jms_complaint_registrations.deleted_at', null)
            ->where('jms_complaint_registrations.deleted_by', null)
            ->orderBy('jms_complaint_registrations.created_at', 'DESC')
            ->whereBetween('reg_date', [$startDate, $endDate])
            ->when(!$this->selectedReconciliationCenter, function ($query) {
                $query->whereNull('reconciliation_center_id');
            })
            ->when(true, function ($query) {
                if ($this->selectedStatus === 'pending') {
                    $query->whereNull('status');
                } elseif ($this->selectedStatus === '0' || $this->selectedStatus === '1') {
                    $query->where('status', $this->status);
                }
                $query->when($this->selectedWard, function ($query) {
                    $query->where('ward_no', $this->selectedWard);
                });

                $query->when($this->selectedDisputeMatter, function ($query) {
                    $query->where('dispute_matter_id', $this->selectedDisputeMatter);
                });

                $query->when($this->selectedDisputeArea, function ($query) {
                    $query->whereHas('disputeMatter', function ($q) {
                        $q->where('dispute_area_id', $this->selectedDisputeArea);
                    });
                });

                $query->when($this->selectedReconciliationCenter, function ($query) {
                    $query->where('reconciliation_center_id', $this->selectedReconciliationCenter);
                });
            })
            ->get();

        if ($complaints->isEmpty()) {
            $this->errorToast(__('ejalas::ejalas.no_data_found'));
            return;
        }
        foreach ($complaints as $complaintRegistration) {  //converted english date to nepali
            $complaintRegistration->reg_date_bs = replaceNumbers(
                $this->adToBs(Carbon::parse($complaintRegistration->reg_date)->format('Y-m-d')),
                true
            );
            $complaintRegistration->defenders = $complaintRegistration->parties()->where('complaint_party.type', 'Defender')->pluck('name')->toArray();
            $complaintRegistration->complainers = $complaintRegistration->parties()->where('complaint_party.type', 'Complainer')->pluck('name')->toArray();
        }

        $startDateNp = $this->startDate;
        $endDateNp = $this->endDate;


        $service = new ReportAdminService();

        $commonReportData = $service->commonDataForReport();

        $viewData = array_merge($commonReportData, compact('complaints', 'startDateNp', 'endDateNp'));
        $html = view('Ejalas::livewire.complaint-registration.pdf', $viewData)->render();
        return $service->getReport($html);
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
