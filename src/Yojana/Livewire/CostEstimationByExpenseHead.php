<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\Yojana\DTO\SourceTypeAdminDto;
use Src\Yojana\Exports\PlanReportExport;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Service\SourceTypeAdminService;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;
use Src\Yojana\Enums\Natures;
use Src\Yojana\Enums\PlanTypes;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectGroup;
use Src\Yojana\Models\SubRegion;
use Src\Yojana\Models\Target;

class CostEstimationByExpenseHead extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;
    public $plans;
    public $startDate;
    public $endDate;
    public $implementationMethods;
    public $subRegions;
    public $expenseHead;
    public $targets;
    public $implementationLevels;
    public $planTypes;
    public $natures;
    public $projectGroups;
    public $wards;
    public $type;

    public $selectedExpenseHead;
    public $query;
    public $expenseHeads;

    public function rules(): array
    {
        return [
            'selectedExpenseHead' => 'nullable',
        ];
    }


    public function render()
    {
        return view("Yojana::livewire.reports.cost-estimation-by-expense-head");
    }

    public function mount()
    {
        $this->expenseHeads = ExpenseHead::whereNull('deleted_at')
            ->pluck('title', 'id');

        $this->query = ExpenseHead::whereNull('deleted_at')
            ->whereHas('plans')
            ->with('plans.budgetSources', 'plans.costEstimation', 'plans.payments')
            ->get();

        //        dd($this->query);
        //        dd($this->query[0]->plans->count());
        //        dd($this->query[0]->plans[0]->allocated_budget);
        //        dd($this->query[0]->plans[15]->costEstimation->total_cost);
        //        dd($this->query[0]->plans[15]->payments[0]->paid_amount);
    }
    public function search()
    {
        $this->validate();

        $expenseHead = ExpenseHead::whereNull('deleted_at')
            ->whereHas('plans')
            ->with('plans.budgetSources', 'plans.costEstimation', 'plans.payments');

        if ($this->selectedExpenseHead) {
            $expenseHead->where('id', $this->selectedExpenseHead);
        }

        $this->query = $expenseHead->get();
    }
    public function clear()
    {
        $this->reset([
            'selectedExpenseHead',
        ]);
    }
    public function downloadPdf()
    {
        try {
            $query =  $this->query;

            $startDate = $this->startDate;
            $endDate = $this->endDate;
            if (empty($query)) {
                $this->errorToast(__('yojana::yojana.no_data_found'));
                return;
            }
            $user = Auth::user();
            $ward = GlobalFacade::ward();

            $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

            $header = $this->getLetterHeader($ward); //get letter header from the helper template
            $html = view('Yojana::livewire.reports.pdf.pdf-cost-estimation-expense-head', compact('nepaliDate',  'startDate', 'endDate', 'query', 'header'))->render();
            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana" . date('YmdHis'),
                disk: getStorageDisk('private'),
            );
            $this->dispatch('open-pdf-in-new-tab', url: $url);
            //            return redirect()->away($url);
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
                'implementationMethod',
                'planArea',
                'subRegion',
                'target',
                'implementationLevel',
                'projectGroup',
                'sourceType',
                'program',
                'budgetHead',
                'expenseHead',
                'ward',
                'fiscalYear'
            ]); //explicitly loaded this relation to fix the error of lazy loading
            $exportFilePath = 'plan-report.xlsx';
            return Excel::download(new PlanReportExport($this->plans), $exportFilePath);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            dd($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
}
