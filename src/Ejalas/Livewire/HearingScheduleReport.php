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
use Src\FiscalYears\Models\FiscalYear;
use Illuminate\Support\Facades\Log;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use Carbon\Carbon;
use Src\Ejalas\Models\HearingSchedule;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\ReportAdminService;

class HearingScheduleReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $startDate;
    public $endDate;
    public $reconciliationCenters;
    public $selectedReconciliationCenter;
    public $hearingSchedules = [];

    public  $nepaliDate;
    public $letterHead;

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required',
        'selectedReconciliationCenter' => 'nullable'
    ];

    public function render()
    {
        return view("Ejalas::livewire.hearing-schedule.report");
    }

    public function mount()
    {
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');

        $this->nepaliDate =  $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $this->letterHead =  $this->getBusinessLetterHeaderFromSample();
    }

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->hearingSchedules = HearingSchedule::with(['complaintRegistration', 'fiscalYear', 'reconciliationCenter', 'complaintRegistration.parties', 'complaintRegistration.disputeMatter', 'complaintRegistration.disputeMatter.disputeArea'])
            ->whereNull('deleted_at')
            ->whereBetween('hearing_date_en', [$startDate, $endDate])
            ->when($this->selectedReconciliationCenter, function ($query) {
                $query->where('reconciliation_center_id', $this->selectedReconciliationCenter);
            })
            ->latest()
            ->get();
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'selectedReconciliationCenter', 'hearingSchedules']);
    }



    public function downloadPdf()
    {

        if (!$this->hearingSchedules) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
}
