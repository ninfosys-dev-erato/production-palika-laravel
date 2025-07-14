<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\DTO\GrievanceTypeAdminDto;
use Src\Grievance\Models\GrievanceType;
use Src\Grievance\Service\GrievanceTypeAdminService;

class GrievanceTypeForm extends Component
{
    use SessionFlash;

    public ?GrievanceType $grievanceType;
    public ?Action $action;
    public $selectedRoles = [];
    public $selectedDepartments = [];

    public function rules(): array
    {
        return [
            'grievanceType.title' => ['required'],
            'grievanceType.is_ward' => ['nullable', 'boolean'],
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.form");
    }

    public function mount(GrievanceType $grievanceType, Action $action): void
    {
        $this->grievanceType = $grievanceType;
        $this->action = $action;
        $this->selectedRoles = $this->grievanceType->roles?->pluck('id')->toArray() ?? [];
        $this->selectedDepartments = $this->grievanceType->departments?->pluck('id')->toArray() ?? [];
        $this->grievanceType->is_ward = (bool) $this->grievanceType->is_ward;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = GrievanceTypeAdminDto::fromLiveWireModel($this->grievanceType);
            $service = new GrievanceTypeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto, $this->selectedRoles, $this->selectedDepartments);
                    $this->successFlash(__('grievance::grievance.grievance_type_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->grievanceType, $dto, $this->selectedRoles, $this->selectedDepartments);
                    $this->successFlash(__('grievance::grievance.grievance_type_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.grievance.grievanceType.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
           $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function messages(): array
    {
        return [
            'grievanceType.title' => __('grievance::grievance.the_title_is_required'),
        ];
    }
}

