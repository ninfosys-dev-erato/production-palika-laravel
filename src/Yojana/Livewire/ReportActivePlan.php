<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Foundation\Exceptions\Renderer\Listener;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\Yojana\DTO\SourceTypeAdminDto;
use Src\Yojana\Exports\PlanReportExport;
use Src\Yojana\Exports\ReportPlanByCompletionExcel;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Service\SourceTypeAdminService;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;
use Src\Yojana\Enums\Natures;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Enums\PlanTypes;
use Src\Yojana\Exports\ReportActivePlanExcel;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectGroup;
use Src\Yojana\Models\SubRegion;
use Src\Yojana\Models\Target;

class ReportActivePlan extends Component
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

    public $selectedPlanArea;
    public $selectedExpenseHead;
    public $query;
    public $projectName;
    public $wards;
    public $selectedWard;
    public $projectLocation;

    public function rules(): array
    {
        return [
            'selectedPlanArea' => 'nullable',
            'selectedExpenseHead' => 'nullable',
            'projectName' => 'nullable',
            'projectLocation' => 'nullable',
        ];
    }


    public function render()
    {
        return view("Yojana::livewire.reports.active-plan");
    }

    public function mount()
    {
        $this->planAreas = PlanArea::whereNull('deleted_at')
            ->pluck('area_name', 'id');
        $this->expenseHeads = ExpenseHead::whereNull('deleted_at')->pluck('title', 'id');

        $this->plans = Plan::whereNull('deleted_at')->where('status', '!=', PlanStatus::Completed)->with('planArea', 'expenseHead', 'budgetSources.expenseHead',  'receivedTransfers', 'targetEntries.targetCompletions')->get();




        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }
    public function search()
    {
        $this->validate();
        $query = Plan::whereNull('deleted_at')->where('status', '!=', PlanStatus::Completed)->with('planArea', 'expenseHead', 'budgetSources.expenseHead',  'receivedTransfers', 'targetEntries.targetCompletions');

        if ($this->projectName) {
            $query->where('project_name', 'like', '%' . $this->projectName . '%');
        }
        if ($this->projectLocation) {
            $query->where('location', 'like', '%' . $this->projectLocation . '%');
        }
        if ($this->selectedPlanArea) {
            $query->where('area_id', $this->selectedPlanArea);
        }
        if ($this->selectedExpenseHead) {
            $query->whereHas('budgetSources.expenseHead', function ($q) {
                $q->where('id', $this->selectedExpenseHead);
            });
        }
        if ($this->selectedWard) {
            $query->where('ward_id', $this->selectedWard);
        }

        $this->plans = $query->get();
    }
    public function clear()
    {
        $this->reset([
            'selectedPlanArea',
            'selectedExpenseHead',
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
            $plans->load('planArea', 'expenseHead', 'budgetSources.expenseHead',  'receivedTransfers', 'targetEntries.targetCompletions');

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
            $html = view('Yojana::livewire.reports.pdf.pdf-active-plan', compact('nepaliDate',  'plans', 'header'))->render();
            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana" . date('YmdHis'),
                disk: getStorageDisk('private'),
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
                'planArea',
                'expenseHead',
                'budgetSources.expenseHead',
                'targetEntries'

            ]); //explicitly loaded this relation to fix the error of lazy loading
            $exportFilePath = 'plan-report.xlsx';
            return Excel::download(new ReportActivePlanExcel($this->plans), $exportFilePath);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            dd($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
}
