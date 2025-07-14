<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\JudicialEmployeeAdminDto;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Models\Level;
use Src\Ejalas\Models\LocalLevel;
use Src\Ejalas\Service\JudicialEmployeeAdminService;
use Src\Employees\Models\Designation;
use Livewire\Attributes\On;

class JudicialEmployeeForm extends Component
{
    use SessionFlash;

    public ?JudicialEmployee $judicialEmployee;
    public ?Action $action = Action::CREATE;

    public $localLevels;
    public $levels;
    public $designations;
    public $wards;
    public function rules(): array
    {
        return [
            'judicialEmployee.name' => ['required'],
            'judicialEmployee.local_level_id' => ['required'],
            'judicialEmployee.ward_id' => ['required'],
            'judicialEmployee.level_id' => ['required'],
            'judicialEmployee.designation_id' => ['required'],
            'judicialEmployee.join_date' => ['required'],
            'judicialEmployee.phone_no' => ['required'],
            'judicialEmployee.email' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.judicial-employee.form");
    }

    public function mount(JudicialEmployee $judicialEmployee, Action $action)
    {
        $this->judicialEmployee = $judicialEmployee;
        $this->action = $action;

        $this->localLevels = LocalLevel::whereNull('deleted_at')->pluck('title', 'id');
        $this->levels = Level::whereNull('deleted_at')->pluck('title_en', 'id');
        $this->designations = Designation::whereNull('deleted_at')->pluck('title_en', 'id');

        // $localBody = key(getSetting('palika-local-body'));
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = JudicialEmployeeAdminDto::fromLiveWireModel($this->judicialEmployee);
            $service = new JudicialEmployeeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_employee_created_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_employees.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->judicialEmployee, $dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_employee_updated_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_employees.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.judicial_employees.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-judicial-employee')]
    public function editJudicialEmployee(JudicialEmployee $judicialEmployee)
    {
        $this->judicialEmployee = $judicialEmployee;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['judicialEmployee', 'action']);
        $this->judicialEmployee = new JudicialEmployee();
    }
    #[On('reset-form')]
    public function resetJudicialEmployee()
    {
        $this->resetForm();
    }
}
