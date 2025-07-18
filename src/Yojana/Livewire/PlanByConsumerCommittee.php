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
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Exports\PlanReportExport;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\ConsumerCommittee;
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

class PlanByConsumerCommittee extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;
    public $plans;
    public $startDate;
    public $endDate;
    public $implementationMethods;
    public $subRegions;
    public $targets;
    public $implementationLevels;
    public $planTypes;
    public $natures;
    public $projectGroups;
    public $wards;
    public $type;

    public $selectedConsumerCommittee;
    public $query;
    public $consumerCommittees;

    public function rules(): array
    {
        return [
            'selectedConsumerCommittee' => 'nullable',
        ];
    }


    public function render()
    {
        return view("Yojana::livewire.reports.plan-by-consumer-committee");
    }

    public function mount()
    {
        $this->consumerCommittees = ConsumerCommittee::whereNull('deleted_at')
            ->pluck('name', 'id');

        $this->query = Plan::whereNull('deleted_at')
            ->whereHas('implementationMethod', function ($query) {
                $query->where('model', ImplementationMethods::OperatedByConsumerCommittee);
            })
            ->with('implementationMethod', 'implementationAgency.consumerCommittee.committeeMembers')
            ->get();

        //        dd(
        //            $this->query[0]->implementationAgency->consumerCommittee->committeeMembers->where('designation', 'chair')->last()->name,
        //            $this->query[0]->implementationAgency->consumerCommittee->committeeMembers->where('designation', 'chair')->last()->address,
        //            $this->query[0]->implementationAgency->consumerCommittee->committeeMembers->where('designation', 'chair')->last()->citizenship_number
        //        );


    }
    public function search()
    {
        $this->validate();

        $plans = Plan::whereNull('deleted_at')
            ->whereHas('implementationMethod', function ($query) {
                $query->where('model', ImplementationMethods::OperatedByConsumerCommittee);
            })
            ->with('implementationMethod', 'implementationAgency.consumerCommittee.committeeMembers');

        if ($this->selectedConsumerCommittee) {
            $plans->whereHas('implementationAgency.consumerCommittee', function ($query) {
                $query->where('id', $this->selectedConsumerCommittee);
            });
        }


        $this->query = $plans->get();
    }
    public function clear()
    {
        $this->reset([
            'selectedConsumerCommittee',
        ]);
    }
    public function downloadPdf()
    {
        try {
            $query =  $this->query;
            $query->load('implementationMethod', 'implementationAgency.consumerCommittee.committeeMembers');

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
            $html = view('Yojana::livewire.reports.pdf.pdf-plan-consumer-committee', compact('nepaliDate',  'startDate', 'endDate', 'query', 'header'))->render();
            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana" . date('YmdHis'),
                disk: "local",
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
