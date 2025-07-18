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
use Carbon\Carbon;
use Src\Ejalas\Models\HearingSchedule;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\ReportAdminService;

class HearingScheduleReport extends Component
{
    use SessionFlash, HelperDate;
    public $startDate;
    public $endDate;
    public $reconciliationCenters;
    public $selectedReconciliationCenter;
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
    }

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->dispatch('getSearchDate', $startDate, $endDate, $this->selectedReconciliationCenter);
    }
    public function downloadPdf()
    {
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);
        $reports = HearingSchedule::with(['complaintRegistration', 'fiscalYear', 'reconciliationCenter', 'complaintRegistration.parties', 'complaintRegistration.disputeMatter', 'complaintRegistration.disputeMatter.disputeArea'])
            ->whereNull('deleted_at')
            ->whereBetween('hearing_date', [$startDate, $endDate])
            ->when($this->selectedReconciliationCenter, function ($query) {
                $query->where('reconciliation_center_id', $this->selectedReconciliationCenter);
            })
            ->latest()
            ->get();
        if ($reports->isEmpty()) {
            $this->errorToast(__('ejalas::ejalas.no_data_found'));
            return;
        }
        foreach ($reports as $report) {  //converted english date to nepali
            $report->hearing_date_bs = replaceNumbers(
                $this->adToBs(Carbon::parse($report->hearing_date)->format('Y-m-d')),
                true
            );

            $report->defenders = $report->complaintRegistration->parties
                ->where('pivot.type', 'Defender')
                ->pluck('name')
                ->toArray();

            $report->complainers = $report->complaintRegistration->parties
                ->where('pivot.type', 'Complainer')
                ->pluck('name')
                ->toArray();
        }

        $startDateNp = $this->startDate;
        $endDateNp = $this->endDate;

        $service = new ReportAdminService();

        $commonReportData = $service->commonDataForReport();

        $viewData = array_merge($commonReportData, compact('reports', 'startDateNp', 'endDateNp'));
        $html = view('Ejalas::livewire.hearing-schedule.pdf', $viewData)->render();

        return $service->getReport($html);
    }
}
