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
use Src\Ejalas\Service\ReportAdminService;

class FiscalYearReport extends Component
{
    use SessionFlash, HelperDate;
    public $fiscalYears;
    public $reportCollections;
    public $selectedYear;
    protected $rules = [
        'selectedYear' => 'required',
    ];

    public function render()
    {
        return view("Ejalas::livewire.fiscal-year.report");
    }

    public function mount()
    {
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
    }

    public function searchReport()
    {
        $this->reportCollections = ComplaintRegistration::selectRaw('dispute_matter_id, COUNT(*) as total')
            ->whereNull('deleted_at')
            ->where('fiscal_year_id', $this->selectedYear)
            ->groupBy('dispute_matter_id')
            ->with('disputeMatter')
            ->get();


        // $this->reportCollections = DisputeArea::selectRaw('jms_dispute_areas.id, jms_dispute_areas.title, COUNT(jms_complaint_registrations.id) as total')
        //     ->join('jms_dispute_matters', 'jms_dispute_matters.dispute_area_id', '=', 'jms_dispute_areas.id')
        //     ->join('jms_complaint_registrations', 'jms_complaint_registrations.dispute_matter_id', '=', 'jms_dispute_matters.id')
        //     ->whereNull('jms_complaint_registrations.deleted_at')
        //     ->where('jms_complaint_registrations.fiscal_year_id', $this->selectedYear)
        //     ->groupBy('jms_dispute_areas.id', 'jms_dispute_areas.title')
        //     ->get();
    }
    public function downloadPdf()
    {
        try {
            $year = $this->selectedYear;
            $reports = ComplaintRegistration::selectRaw('dispute_matter_id, COUNT(*) as total')
                ->whereNull('deleted_at')
                ->where('fiscal_year_id', $this->selectedYear)
                ->groupBy('dispute_matter_id')
                ->with('disputeMatter')
                ->get();

            if ($reports->isEmpty()) {
                $this->errorToast(__('ejalas::ejalas.no_data_found'));
                return;
            }
            $service = new ReportAdminService();

            $commonReportData = $service->commonDataForReport();

            $viewData = array_merge($commonReportData, compact('reports', 'year'));
            $html = view('Ejalas::livewire.fiscal-year.pdf', $viewData)->render();

            return $service->getReport($html);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.')), $e->getMessage());
        }
    }
}
