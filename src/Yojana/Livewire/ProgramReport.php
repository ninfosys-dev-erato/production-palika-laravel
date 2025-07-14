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

class ProgramReport extends Component
{
    use SessionFlash, HelperDate, AdminSettings, HelperTemplate;
    public $plans;
    public $startDate;
    public $endDate;
    public $implementationMethods;
    public $subRegions;
    public $planAreas;
    public $targets;
    public $implementationLevels;
    public $planTypes;
    public $natures;
    public $projectGroups;
    public $wards;

    public $selectedImplementationMethod;
    public $selectedImplementationLevel;
    public $selectedSubRegion;
    public $selectedPlanArea;
    public $selectedTarget;
    public $selectedPlanType;
    public $selectedNature;
    public $selectedProjectGroup;
    public $selectedWard;

    public function rules(): array
    {
        return [
            'startDate' => 'nullable',
            'endDate' => 'nullable',
        ];
    }


    public function render()
    {
        return view("Yojana::livewire.reports.program-report");
    }


    public function mount()
    {
        $this->implementationMethods = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id');
        $this->implementationLevels = ImplementationLevel::whereNull('deleted_at')->pluck('title', 'id');
        $this->subRegions = SubRegion::whereNull('deleted_at')->pluck('name', 'id');
        $this->planAreas = PlanArea::whereNull('deleted_at')->pluck('area_name', 'id');
        $this->targets = Target::whereNull('deleted_at')->pluck('title', 'id');
        $this->planTypes = PlanTypes::cases();
        $this->natures = Natures::cases();
        $this->projectGroups = ProjectGroup::whereNull('deleted_at')->pluck('title', 'id');
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }
    public function search()
    {
        $this->validate();
        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;
        $query = Plan::with([
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
        ])->whereNull('deleted_at')
            ->where('category', 'program')
            ->latest();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($this->selectedWard) {
            $query->where('ward_id', $this->selectedWard);
        }
        if ($this->selectedImplementationMethod) {
            $query->where('implementation_method_id', $this->selectedImplementationMethod);
        }

        if ($this->selectedImplementationLevel) {
            $query->where('implementation_level_id', $this->selectedImplementationLevel);
        }

        if ($this->selectedSubRegion) {
            $query->where('sub_region_id', $this->selectedSubRegion);
        }

        if ($this->selectedPlanArea) {
            $query->where('area_id', $this->selectedPlanArea);
        }

        if ($this->selectedTarget) {
            $query->where('targeted_id', $this->selectedTarget);
        }

        if ($this->selectedPlanType) {
            $query->where('plan_type', $this->selectedPlanType);
        }

        if ($this->selectedNature) {
            $query->where('nature', $this->selectedNature);
        }

        if ($this->selectedProjectGroup) {
            $query->where('project_group_id', $this->selectedProjectGroup);
        }
        $this->plans = $query->get();
    }
    public function clear()
    {
        $this->reset([
            'startDate',
            'endDate',
            'selectedImplementationMethod',
            'selectedImplementationLevel',
            'selectedSubRegion',
            'selectedPlanArea',
            'selectedTarget',
            'selectedPlanType',
            'selectedNature',
            'selectedProjectGroup',
            'selectedWard',
        ]);
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
            $html = view('Yojana::livewire.reports.pdf.program-report', compact('nepaliDate',  'startDate', 'endDate', 'plans', 'header'))->render();
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
