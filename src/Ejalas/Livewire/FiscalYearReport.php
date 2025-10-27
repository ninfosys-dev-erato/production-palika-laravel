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
use Src\Ejalas\Service\ReportAdminService;

class FiscalYearReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $fiscalYears;
    public $reportCollections;
    public $selectedYear;
    public  $nepaliDate;
    public $letterHead;
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
        $this->nepaliDate =  $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $this->letterHead =  $this->getBusinessLetterHeaderFromSample();
    }

    public function searchReport()
    {
        $this->reportCollections = ComplaintRegistration::selectRaw('dispute_matter_id, COUNT(*) as total')
            ->whereNull('deleted_at')
            ->where('fiscal_year_id', $this->selectedYear)
            ->groupBy('dispute_matter_id')
            ->with('disputeMatter')
            ->get();
    }
    public function downloadPdf()
    {
        if (!$this->reportCollections) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
    public function clear()
    {
        $this->reset(['selectedYear', 'reportCollections']);
    }
}
