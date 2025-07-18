<?php

namespace Src\Employees\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\DTO\DesignationAdminDto;
use Src\Employees\Models\Designation;
use Src\Employees\Service\DesignationAdminService;

class DesignationForm extends Component
{
    use SessionFlash;

    public ?Designation $designation;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'designation.title' => ['required'],
            'designation.title_en' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'designation.title.required' => __('employees::employees.the_title_field_is_required'),
            'designation.title_en.required' => __('employees::employees.the_english_title_field_is_required'),
        ];
    }

    public function render()
    {
        return view("Employees::livewire.designation.form");
    }

    public function mount(Designation $designation, Action $action): void
    {
        $this->designation = $designation;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = DesignationAdminDto::fromLiveWireModel($this->designation);
            $service = new DesignationAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('employees::employees.designation_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->designation, $dto);
                    $this->successFlash(__('employees::employees.designation_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.employee.designation.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(__('employees::employees.something_went_wrong_while_saving_') . $e->getMessage());

        }
    }
}

