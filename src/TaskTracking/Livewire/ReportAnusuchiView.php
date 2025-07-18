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
use Illuminate\Support\Str;

class ReportAnusuchiView extends Component
{
    public $employeeMarkingId;
    public $employeeMarking;
    public $groupedScores;

    public function render()
    {
        return view('TaskTracking::livewire.report-anusuchi.anusuchi-report-view');
    }

    public function mount($employeeMarkingId)
    {
        $this->employeeMarkingId = $employeeMarkingId;


        $this->employeeMarking = EmployeeMarking::with([
            'anusuchi',
            'employee',
            'anusuchi.criterion',
            'employeeMarkingScore',
            'employeeMarkingScore.employee',
            'employeeMarkingScore.employee.branch',
            'employeeMarkingScore.employee.designation'
        ])->findOrFail($employeeMarkingId);

        // dd($this->employeeMarking->month);


        $this->groupedScores = $this->employeeMarking->employeeMarkingScore->groupBy('employee_id')->all();

        // dd($this->employeeMarkingId,   $this->employeeMarking,     $this->groupedScores);
    }
}
