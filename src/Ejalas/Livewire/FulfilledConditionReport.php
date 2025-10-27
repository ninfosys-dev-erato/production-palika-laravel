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
use Src\Ejalas\Models\FulfilledCondition;

class FulfilledConditionReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $startDate;
    public $endDate;
    public $fulfilledConditions = [];


    public  $nepaliDate;
    public $letterHead;

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.fulfilled-condition.report");
    }

    public function mount() {
        $this->nepaliDate =  $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
        $this->letterHead =  $this->getBusinessLetterHeaderFromSample();
    }

    public function searchReport()
    {
        $this->validate();
        $startDate = $this->bsToAd($this->startDate);
        $endDate = $this->bsToAd($this->endDate);

        $this->fulfilledConditions = FulfilledCondition::with('complaintRegistration', 'party', 'judicialEmployee', 'SettlementDetail')
            ->whereNull('deleted_at')
            ->whereBetween('entry_date_en', [$startDate, $endDate])
            ->latest()
            ->get();

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
        if (!$this->fulfilledConditions) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
}
