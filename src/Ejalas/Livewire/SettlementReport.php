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
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Service\ReportAdminService;

class SettlementReport extends Component
{
    use SessionFlash, HelperDate;
    public $startDate;
    public $endDate;
    public $settledStatus = 1;
    public $settlements = [];

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.settlement.report");
    }

    public function mount() {}

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->settlements = Settlement::with('complaintRegistration')
            ->whereNull('deleted_at')
            ->whereBetween('settlement_date', [$startDate, $endDate])
            ->when($this->settledStatus, function ($query) {
                $query->where('is_settled', $this->settledStatus);
            })
            ->latest()
            ->get();

        foreach ($this->settlements as $settlement) {
            $settlement->settlement_date_bs = replaceNumbers(
                $this->adToBs(Carbon::parse($settlement->settlement_date)->format('Y-m-d')),
                true
            );
        }
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'settlements']);
    }

    public function export()
    {
        // Export functionality can be implemented here
        $this->searchReport();
        // Add export logic
    }

    public function downloadPdf()
    {
        $this->validate();
        try {
            $startDate = $this->bsToAd($this->startDate);
            $endDate = $this->bsToAd($this->endDate);
            $reports = Settlement::with('complaintRegistration')
                ->whereNull('deleted_at')
                ->whereBetween('settlement_date', [$startDate, $endDate])
                ->when($this->settledStatus, function ($query) {
                    $query->where('is_settled', $this->settledStatus);
                })
                ->latest()
                ->get();
            if ($reports->isEmpty()) {
                $this->errorToast(__('ejalas::ejalas.no_data_found'));
                return;
            }
            foreach ($reports as $report) {  //converted english date to nepali
                $report->discussion_date_bs = replaceNumbers(
                    $this->adToBs(Carbon::parse($report->discussion_date)->format('Y-m-d')),
                    true
                );
                $report->settlement_date_bs = replaceNumbers(
                    $this->adToBs(Carbon::parse($report->settlement_date)->format('Y-m-d')),
                    true
                );
            }
            $startDateNp = $this->startDate;
            $endDateNp = $this->endDate;

            $service = new ReportAdminService();

            $commonReportData = $service->commonDataForReport();

            $viewData = array_merge($commonReportData, compact('reports', 'startDateNp', 'endDateNp'));
            $html = view('Ejalas::livewire.settlement.pdf', $viewData)->render();

            return $service->getReport($html);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong.')));
        }
    }
}
