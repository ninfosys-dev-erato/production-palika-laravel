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
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Models\SettlementDetail;
use Src\Ejalas\Service\ReportAdminService;

class SettlementReport extends Component
{
    use SessionFlash, HelperDate, HelperTemplate;
    public $startDate;
    public $endDate;
    public $settledStatus;
    public $settlements = [];

    public  $nepaliDate;
    public $letterHead;

    protected $rules = [
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    public function render()
    {
        return view("Ejalas::livewire.settlement.report");
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
        $this->settlements = SettlementDetail::with(['complaintRegistration', 'party'])
            ->whereNull('deleted_at')
            ->whereIn('complaint_registration_id', function ($query) use ($startDate, $endDate) {
                $query->select('complaint_registration_id')
                    ->from('jms_settlements')
                    ->whereNull('deleted_at')
                    ->whereBetween('discussion_date_en', [$startDate, $endDate]);
            })
            ->when($this->settledStatus !== null, function ($query) {
                $query->where('is_settled', $this->settledStatus);
            })
            ->latest()
            ->get();


    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'settlements']);
    }



    public function downloadPdf() {
        if (!$this->settlements) {
            return $this->errorToast('ejalas::ejalas.no_data_found');
        }
        $this->dispatch('print-report');
    }
}
