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
use Illuminate\Support\Facades\Log;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use Carbon\Carbon;
use Src\Ejalas\Models\CaseRecord;

class CaseRecordReport extends Component
{
    use SessionFlash, HelperDate;
    public $startDate;
    public $endDate;
    public $caseRecords = [];

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.case-record.report");
    }

    public function mount() {}

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->caseRecords = CaseRecord::with(['complaintRegistration', 'judicialMember', 'judicialEmployee'])
            ->whereNull('deleted_at')
            ->whereBetween('decision_date', [$startDate, $endDate])
            ->latest()
            ->get();

        foreach ($this->caseRecords as $caseRecord) {
            $caseRecord->decision_date_bs = replaceNumbers(
                $this->adToBs(Carbon::parse($caseRecord->decision_date)->format('Y-m-d')),
                true
            );
        }
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'caseRecords']);
    }

    public function export()
    {
        // Export functionality can be implemented here
        $this->searchReport();
        // Add export logic
    }

    public function downloadPdf()
    {
        // $this->validate();
        try {
            $startDate = $this->bsToAd($this->startDate);
            $endDate = $this->bsToAd($this->endDate);
            $reports = CaseRecord::with(['complaintRegistration', 'judicialMember', 'judicialEmployee'])
                ->whereNull('deleted_at')
                ->whereBetween('decision_date', [$startDate, $endDate])
                ->latest()
                ->get();

            if ($reports->isEmpty()) {
                $this->errorToast(__('ejalas::ejalas.no_data_found'));
                return;
            }
            foreach ($reports as $report) {  //converted english date to nepali
                $report->decision_date_bs = replaceNumbers(
                    $this->adToBs(Carbon::parse($report->decision_date)->format('Y-m-d')),
                    true
                );
            }
            $startDateNp = $this->startDate;
            $endDateNp = $this->endDate;

            $service = new ReportAdminService();

            $commonReportData = $service->commonDataForReport();

            $viewData = array_merge($commonReportData, compact('reports', 'startDateNp', 'endDateNp'));
            $html = view('Ejalas::livewire.case-record.pdf', $viewData)->render();

            return $service->getReport($html);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
