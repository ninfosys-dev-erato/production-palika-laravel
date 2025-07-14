<?php

namespace Src\TaskTracking\Livewire;

use App\Facades\GlobalFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Collection;
use Livewire\Component;
use Src\Employees\Models\Employee;
use Src\TaskTracking\Models\Anusuchi;
use Src\TaskTracking\Models\EmployeeMarking;
use Src\TaskTracking\Models\EmployeeMarkingScore;
use Livewire\Attributes\On;
use App\Models\User;
use App\Enums\Action;
use Illuminate\Support\Facades\DB;
use Src\TaskTracking\DTO\EmployeeMarkingAdminDto;
use Src\TaskTracking\DTO\EmployeeMarkingScoreAdminDto;
use Src\TaskTracking\Service\EmployeeMarkingAdminService;
use Src\TaskTracking\Service\EmployeeMarkingScoreAdminService;

class ReportAnusuchi extends Component
{
    use HelperDate, SessionFlash;

    public $anusuchi = null;
    public Collection $anusuchis;
    public $ward;
    public $employees = [];
    public array $formData = [];
    public $fiscalYear;
    public $selectedMonth;
    public $anusuchiDate;
    public ?Anusuchi $selectedAnusuchi = null;
    public $selectedSignee;
    public $employeeMarkingId = null;
    public ?Action $action;
    public $nepaliMonths = [];

    public EmployeeMarking $employeeMarking;
    public array $employeeMarkingScores = [];


    public function rules()
    {
        return [
            'employeeMarking.fiscal_year' => 'required|string',
            'employeeMarking.anusuchi_id' => 'required|integer|exists:anusuchis,id',
            'selectedMonth' => 'required|string',
            'anusuchiDate' => 'required|date',
            'selectedSignee.id'  => 'required|integer|exists:users,id',
            'formData.*.*.obtained'  => 'required|numeric|min:0',
        ];
    }
    public function mount(Action $action, $employeeMarkingId = null)
    {
        $this->action = $action;
        $this->employeeMarkingId = $employeeMarkingId;

        $this->employeeMarking = new EmployeeMarking();

        $this->employeeMarking->fiscal_year = getSetting('fiscal-year');

        $locale = app()->getLocale();

        $this->anusuchis = Anusuchi::with('criterion')
            ->whereNull('deleted_at')
            ->get(['id', 'name', 'name_en'])
            ->map(fn($item) => tap($item, fn(&$it) => $it->name = $locale !== 'en' ? $it->name : $it->name_en));

        $this->nepaliMonths = $this->getNepaliMonths();
        $this->ward = GlobalFacade::ward();


        if ($this->action === Action::UPDATE && $this->employeeMarkingId) {
            $this->loadData();
        }
    }

    private function loadData()
    {
        // Load marking with its scores
        $marking = EmployeeMarking::with('employeeMarkingScore')
            ->findOrFail($this->employeeMarkingId);

        // Set selection fields
        $this->selectedAnusuchi = Anusuchi::with('criterion')
            ->find($marking->anusuchi_id);
        $this->anusuchi = $marking->anusuchi_id;
        $this->selectedMonth = $marking->month;
        $this->anusuchiDate = $marking->date_from;
        $this->fiscalYear = $marking->fiscal_year;
        $this->selectedSignee = $marking->employee_id;

        $employeeIds = $marking->employeeMarkingScore->pluck('employee_id')->toArray();


        // Prepare employees list and full scores
        $this->employees = Employee::whereIn('id', $employeeIds)
            ->with('branch', 'designation')
            ->get();

        foreach ($this->employees as $e) {
            foreach ($this->selectedAnusuchi->criterion as $crit) {
                $this->formData[$e->id][$crit->id]['full'] = $crit->max_score;
            }
        }

        foreach ($marking->employeeMarkingScore as $score) {
            $this->formData[$score->employee_id][$score->criteria_id]['obtained'] = $score->score_obtained;
            $this->formData[$score->employee_id]['remarks'] = $score->remarks;
        }

        foreach ($this->employees as $emp) {
            $this->updateTotal($emp->id);
        }
    }
    public function updateTotal($employeeId)
    {
        $total = 0;
        if (!empty($this->formData[$employeeId])) {
            foreach ($this->formData[$employeeId] as $data) {
                if (is_array($data) && isset($data['obtained']) && is_numeric($data['obtained'])) {
                    $total += (float) $data['obtained'];
                }
            }
        }
        $this->formData[$employeeId]['total'] = $total;
    }

    public function getAnusuchiValue()
    {
        $this->selectedAnusuchi = Anusuchi::with('criterion')->find($this->anusuchi);

        $this->employees = Employee::whereNull('deleted_at')
            ->where('ward_no', $this->ward)
            ->with('branch', 'designation')
            ->get();

        foreach ($this->employees as $e) {
            foreach ($this->selectedAnusuchi->criterion as $crit) {
                $this->formData[$e->id][$crit->id]['full'] = $crit->max_score;
            }
        }
    }

    #[On('signee-selected')]
    public function setSignee(User $signee)
    {
        $this->selectedSignee = $signee->id;
    }

    public function save()
    {
        DB::beginTransaction();
        try {
            $this->loadEmployeeMarking();

            $employeeMarkingDto = EmployeeMarkingAdminDto::fromLiveWireModel($this->employeeMarking);
            $employeeMarkingService = new EmployeeMarkingAdminService;

            if ($this->action === Action::CREATE) {
                $marking = $employeeMarkingService->store($employeeMarkingDto);
            }
            if ($this->action === Action::UPDATE) {
                $marking = EmployeeMarking::findOrFail($this->employeeMarkingId);
                $employeeMarkingService->update($marking, $employeeMarkingDto);
                EmployeeMarkingScore::where('employee_marking_id', $marking->id)->delete();
            }
            $this->loadEmployeeMarkingScore($marking->id);

            $employeeMarkingService = new EmployeeMarkingScoreAdminService;

            foreach ($this->employeeMarkingScores as $scoreData) {
                $employeeMarkingScoreDto = EmployeeMarkingScoreAdminDto::fromArray($scoreData);
                $employeeMarkingService->store($employeeMarkingScoreDto);
            }
            DB::comit();
            $this->successToast(__('tasktracking::tasktracking.saved_successfully'));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->errorToast(__('tasktracking::tasktracking.something_went_wrong'));
        }
    }

    public function render()
    {
        return view('TaskTracking::livewire.report-anusuchi.report-anusuchi');
    }

    public function loadEmployeeMarking()
    {
        $totalOut = 0;
        $totalObtained = 0;

        foreach ($this->formData as $empId => $data) {
            foreach ($data as $critId => $vals) {
                if (in_array($critId, ['total', 'remarks'], true)) continue;
                $totalOut += (float) ($vals['full'] ?? 0);
                $totalObtained += (float) ($vals['obtained'] ?? 0);
            }
        }

        $this->employeeMarking->employee_id = $this->selectedSignee;
        $this->employeeMarking->anusuchi_id = $this->selectedAnusuchi->id;
        $this->employeeMarking->full_score = $totalOut;
        $this->employeeMarking->obtained_score = $totalObtained;
        $this->employeeMarking->anusuchi_id = $this->selectedAnusuchi->id;
        $this->employeeMarking->month = $this->selectedMonth;
        $this->employeeMarking->period_type = 'monthly';
        $this->employeeMarking->date_from = $this->anusuchiDate;
        $this->employeeMarking->date_to = $this->anusuchiDate;
    }
    public function loadEmployeeMarkingScore(int $markingId)
    {
        $this->employeeMarkingScores = [];
        foreach ($this->formData as $empId => $data) {
            $remarks = $data['remarks'] ?? null;
            foreach ($data as $critId => $vals) {
                if (in_array($critId, ['total', 'remarks'], true)) continue;
                $this->employeeMarkingScores[] = [
                    'employee_marking_id' => $markingId,
                    'employee_id'         => $empId,
                    'anusuchi_id'         => $this->selectedAnusuchi->id,
                    'criteria_id'         => $critId,
                    'score_obtained'      => $vals['obtained'] ?? null,
                    'score_out_of'        => $vals['full'] ?? null,
                    'remarks'             => $remarks,
                ];
            }
        }
    }
}
