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
use Src\Ejalas\Models\CaseRecord;

class CaseRecordReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $startDate;
    public $endDate;
    public $caseRecords = [];

    public  $nepaliDate;
    public $letterHead;

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.case-record.report");
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

        $this->caseRecords = CaseRecord::with(['complaintRegistration', 'judicialMember', 'judicialEmployee'])
            ->whereNull('deleted_at')
            ->whereBetween('decision_date_en', [$startDate, $endDate])
            ->latest()
            ->get();
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'caseRecords']);
    }


    public function downloadPdf()
    {
        if (!$this->caseRecords) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
}
