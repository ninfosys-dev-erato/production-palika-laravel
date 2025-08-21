<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Models\SubCategory;
use Src\Employees\Models\Branch;
use Src\FiscalYears\Models\FiscalYear;
use Src\Settings\Traits\AdminSettings;

class BerujuReport extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;

    protected $listeners = ['print-pdf' => 'downloadPdf'];

    public $berujuEntries;
    public $startDate;
    public $endDate;
    
    // Filter options
    public $auditTypes;
    public $berujuCategories;
    public $berujuStatuses;
    public $submissionStatuses;
    public $subCategories;
    public $branches;
    public $fiscalYears;
    
    // Filter values
    public $selectedAuditType;
    public $selectedBerujuCategory;
    public $selectedBerujuStatus;
    public $selectedSubmissionStatus;
    public $selectedSubCategory;
    public $selectedBranch;
    public $selectedFiscalYear;
    public $projectName;
    public $referenceNumber;
    public $ownerName;

    public function rules(): array
    {
        return [
            'selectedAuditType' => 'nullable',
            'selectedBerujuCategory' => 'nullable',
            'selectedBerujuStatus' => 'nullable',
            'selectedSubmissionStatus' => 'nullable',
            'selectedSubCategory' => 'nullable',
            'selectedBranch' => 'nullable',
            'selectedFiscalYear' => 'nullable',
            'projectName' => 'nullable',
            'referenceNumber' => 'nullable',
            'ownerName' => 'nullable',
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.reports.beruju-report");
    }

    public function mount()
    {
        // Load filter options
        $this->loadFilterOptions();
        
        // Load initial data
        $this->loadBerujuEntries();
    }

    private function loadFilterOptions()
    {
        // Load audit types
        $this->auditTypes = BerujuAduitTypeEnum::getForWeb();
        
        // Load beruju categories
        $this->berujuCategories = BerujuCategoryEnum::getForWeb();
        
        // Load beruju statuses
        $this->berujuStatuses = BerujuStatusEnum::getForWeb();
        
        // Load submission statuses
        $this->submissionStatuses = BerujuSubmissionStatusEnum::getForWeb();
        
        // Load sub categories
        $this->subCategories = SubCategory::whereNull('deleted_at')
            ->pluck('name_nep', 'id')
            ->toArray();
        
        // Load branches
        $this->branches = Branch::whereNull('deleted_at')
            ->pluck('title', 'id')
            ->toArray();
        
        // Load fiscal years
        $this->fiscalYears = getFiscalYears()->pluck('year', 'id')->toArray();
    }

    private function loadBerujuEntries()
    {
        $query = BerujuEntry::whereNull('deleted_at')
            ->whereIn('sub_category_id', [2,4,1])
            ->orwhereHas('subCategory', function($q) {
                $q->whereIn('parent_id', [2,4,1]);
            })
            ->with([
                'creator', 
                'updater', 
                'fiscalYear', 
                'branch', 
                'subCategory',
                'evidences',
                'resolutionCycles.actions.actionType',
                'latestResolutionCycle.actions'
            ]);

        $this->applyFilters($query);
        
        $this->berujuEntries = $query->orderBy('created_at', 'DESC')->get();
    }

    private function applyFilters($query)
    {
        if ($this->selectedAuditType) {
            $query->where('audit_type', $this->selectedAuditType);
        }
        
        if ($this->selectedBerujuCategory) {
            $query->where('beruju_category', $this->selectedBerujuCategory);
        }
        
        if ($this->selectedBerujuStatus) {
            $query->where('status', $this->selectedBerujuStatus);
        }
        
        if ($this->selectedSubmissionStatus) {
            $query->where('submission_status', $this->selectedSubmissionStatus);
        }
        
        if ($this->selectedSubCategory) {
            $query->where('sub_category_id', $this->selectedSubCategory);
        }
        
        if ($this->selectedBranch) {
            $query->where('branch_id', $this->selectedBranch);
        }
        
        if ($this->selectedFiscalYear) {
            $query->where('fiscal_year_id', $this->selectedFiscalYear);
        }
        
        if ($this->projectName) {
            $query->where('project', 'like', '%' . $this->projectName . '%');
        }
        
        if ($this->referenceNumber) {
            $query->where('reference_number', 'like', '%' . $this->referenceNumber . '%');
        }
        
        if ($this->ownerName) {
            $query->where('owner_name', 'like', '%' . $this->ownerName . '%');
        }
    }

    public function search()
    {
        $this->validate();
        $this->loadBerujuEntries();
    }

    public function clear()
    {
        $this->reset([
            'selectedAuditType',
            'selectedBerujuCategory',
            'selectedBerujuStatus',
            'selectedSubmissionStatus',
            'selectedSubCategory',
            'selectedBranch',
            'selectedFiscalYear',
            'projectName',
            'referenceNumber',
            'ownerName'
        ]);
        
        $this->loadBerujuEntries();
    }

    public function downloadPdf()
    {
        try {
            if (empty($this->berujuEntries)) {
                $this->errorToast(__('beruju::beruju.no_data_found'));
                return;
            }

            $user = Auth::user();
            $ward = GlobalFacade::ward();

            $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

            $header = $this->getLetterHeader($ward);
            $html = view('Beruju::livewire.reports.pdf.pdf-beruju-report', [
                'nepaliDate' => $nepaliDate,
                'berujuEntries' => $this->berujuEntries,
                'header' => $header
            ])->render();
            
            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Beruju.beruju.reports'),
                file_name: "beruju-report-" . date('YmdHis'),
                disk: "local",
            );
            
            $this->dispatch('open-pdf-in-new-tab', url: $url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while generating PDF.', $e->getMessage());
        }
    }

    public function export()
    {
        try {
            if (empty($this->berujuEntries)) {
                $this->errorToast(__('beruju::beruju.no_data_found'));
                return;
            }

            // Load relationships for export
            $this->berujuEntries->load([
                'creator', 
                'updater', 
                'fiscalYear', 
                'branch', 
                'subCategory',
                'evidences',
                'resolutionCycles.actions.actionType'
            ]);

            $exportFilePath = 'beruju-report.xlsx';
            // You can create an Excel export class similar to Yojana if needed
            // return Excel::download(new BerujuReportExcel($this->berujuEntries), $exportFilePath);
            
            $this->successToast('Export functionality will be implemented soon.');
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while exporting.', $e->getMessage());
        }
    }

    // Helper methods for calculations
    public function getTotalAmount()
    {
        return $this->berujuEntries->sum('amount');
    }

    public function getTotalMonetaryBeruju()
    {
        return $this->berujuEntries->where('beruju_category', BerujuCategoryEnum::MONETARY_BERUJU->value)->count();
    }

    public function getTotalTheoreticalBeruju()
    {
        return $this->berujuEntries->where('beruju_category', BerujuCategoryEnum::THEORETICAL_BERUJU->value)->count();
    }

    public function getStatusCount($status)
    {
        return $this->berujuEntries->where('status', $status)->count();
    }
}
