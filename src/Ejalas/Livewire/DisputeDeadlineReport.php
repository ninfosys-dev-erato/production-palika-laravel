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
use App\Traits\HelperTemplate;
use Carbon\Carbon;
use Src\Ejalas\Models\DisputeDeadline;

class DisputeDeadlineReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $startDate;
    public $endDate;
    public $disputeDeadlines = [];

    public  $nepaliDate;
    public $letterHead;

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.dispute-deadline.report");
    }

    public function mount()
    {
        $this->nepaliDate =  $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $this->letterHead =  $this->getBusinessLetterHeaderFromSample();
    }

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->disputeDeadlines = DisputeDeadline::with(['complaintRegistration.parties', 'complaintRegistration.disputeMatter', 'complaintRegistration', 'judicialEmployee'])
            ->whereNull('deleted_at')
            ->whereBetween('deadline_set_date_en', [$startDate, $endDate])
            ->latest()
            ->get();
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'disputeDeadlines']);
    }

    public function export()
    {
        // Export functionality can be implemented here
        $this->searchReport();
        // Add export logic
    }

    public function downloadPdf()
    {
        if (!$this->disputeDeadlines) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
}
