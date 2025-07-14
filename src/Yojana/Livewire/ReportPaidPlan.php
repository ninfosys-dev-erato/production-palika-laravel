<?php

namespace Src\Yojana\Livewire;

use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\Yojana\Exports\ReportPaidPlanExcel;
use Src\Yojana\Exports\ReportPlanByCompletionExcel;
use Maatwebsite\Excel\Facades\Excel;
use Src\Settings\Traits\AdminSettings;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectGroup;

class ReportPaidPlan extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;

    protected $listeners = ['print-pdf' => 'downloadPdf'];

    public $plans;
    public $startDate;
    public $endDate;
    public $expenseHeads;


    public $implementationMethods;
    public $subRegions;
    public $planAreas;
    public $targets;
    public $implementationLevels;
    public $planTypes;
    public $natures;
    public $projectGroups;
    public $type;
    public $selectedProjectGroup;
    public $selectedExpenseHead;
    public $query;
    public $projectName;
    public $wards;
    public $selectedWard;
    public $projectLocation;

    public function rules(): array
    {
        return [
            'selectedProjectGroup' => 'nullable',
            'selectedExpenseHead' => 'nullable',
            'projectName' => 'nullable',
            'projectLocation' => 'nullable',
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.reports.paid-plan");
    }

    public function mount()
    {
        $this->plans = Plan::whereNull('deleted_at')->where('status', PlanStatus::Completed)->with('implementationMethod','implementationAgency.consumerCommittee', 'implementationAgency.organization', 'implementationAgency.application', 'projectGroup', 'agreement', 'advancePayments', 'payments', 'StartFiscalYear')->get();
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
        $this->projectGroups = ProjectGroup::whereNull('deleted_at')->pluck('title', 'id');
    }
    public function search()
    {
        $this->validate();
        $query = Plan::whereNull('deleted_at')->where('status', PlanStatus::Completed)->with('implementationMethod','implementationAgency.consumerCommittee', 'implementationAgency.organization', 'implementationAgency.application', 'projectGroup', 'agreement', 'advancePayments', 'payments', 'StartFiscalYear');

        if ($this->projectName) {
            $query->where('project_name', 'like', '%' . $this->projectName . '%');
        }
        if ($this->projectLocation) {
            $query->where('location', 'like', '%' . $this->projectLocation . '%');
        }
        if ($this->selectedProjectGroup) {
            $query->where('project_group_id', $this->selectedProjectGroup);
        }
        if ($this->selectedWard) {
            $query->where('ward_id', $this->selectedWard);
        }

        $this->plans = $query->get();
    }
    public function clear()
    {
        $this->reset([
            'selectedProjectGroup',
            'selectedWard',
            'projectLocation',
            'projectName'
        ]);
        $this->search(); //recalls this function to reset the value refetches the query
    }
    public function downloadPdf()
    {
        try {
            $plans =  $this->plans;

            $startDate = $this->startDate;
            $endDate = $this->endDate;
            if (empty($plans)) {
                $this->errorToast(__('yojana::yojana.no_data_found'));
                return;
            }
            $user = Auth::user();
            $ward = GlobalFacade::ward();

            $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

            $header = $this->getLetterHeader($ward); //get letter header from the helper template
            $html = view('Yojana::livewire.reports.pdf.pdf-paid-plan', compact('nepaliDate',  'plans', 'header'))->render();
            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana" . date('YmdHis'),
                disk: "local",
            );
            $this->dispatch('open-pdf-in-new-tab', url: $url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
    public function export()
    {
        try {
            if ($this->plans == null) {
                $this->errorToast(__('yojana::yojana.no_data_found'));
                return;
            }
            $this->plans->load([
                'implementationAgency', 'projectGroup', 'agreement', 'advancePayments', 'payments', 'StartFiscalYear'
            ]); //explicitly loaded this relation to fix the error of lazy loading
            $exportFilePath = 'paid-plan-report.xlsx';

            return Excel::download(new ReportPaidPlanExcel($this->plans), $exportFilePath);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            dd($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
}
