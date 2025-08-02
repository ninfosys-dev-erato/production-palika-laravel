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
use Src\Ejalas\Models\FulfilledCondition;

class FulfilledConditionReport extends Component
{
    use SessionFlash, HelperDate;
    public $startDate;
    public $endDate;
    public $fulfilledConditions = [];

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.fulfilled-condition.report");
    }

    public function mount() {}

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->fulfilledConditions = FulfilledCondition::with('complaintRegistration', 'party', 'judicialEmployee', 'SettlementDetail')
            ->whereNull('deleted_at')
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->latest()
            ->get();

        foreach ($this->fulfilledConditions as $condition) {
            $condition->entry_date_bs = replaceNumbers(
                $this->adToBs(Carbon::parse($condition->entry_date)->format('Y-m-d')),
                true
            );
        }
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'fulfilledConditions']);
    }

    public function export()
    {
        // Export functionality can be implemented here
        $this->searchReport();
        // Add export logic
    }

    public function downloadPdf()
    {
        try {
            $startDate = $this->bsToAd($this->startDate);
            $endDate = $this->bsToAd($this->endDate);
            $reports = FulfilledCondition::with('complaintRegistration', 'party', 'judicialEmployee', 'SettlementDetail')
                ->whereNull('deleted_at')
                ->whereBetween('entry_date', [$startDate, $endDate])
                ->latest()
                ->get();

            if ($reports->isEmpty()) {
                $this->errorToast(__('ejalas::ejalas.no_data_found'));
                return;
            }
            foreach ($reports as $report) {  //converted english date to nepali

                $report->entry_date_bs = replaceNumbers(
                    $this->adToBs(Carbon::parse($report->entry_date)->format('Y-m-d')),
                    true
                );
            }

            $startDateNp = $this->startDate;
            $endDateNp = $this->endDate;


            $service = new ReportAdminService();

            $commonReportData = $service->commonDataForReport();

            $viewData = array_merge($commonReportData, compact('reports', 'startDateNp', 'endDateNp'));
            $html = view('Ejalas::livewire.fulfilled-condition.pdf', $viewData)->render();

            return $service->getReport($html);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.')), $e->getMessage());
        }
    }
}
