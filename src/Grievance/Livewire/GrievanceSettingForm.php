<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\DTO\GrievanceSettingAdminDto;
use Src\Grievance\Models\GrievanceSetting;
use Src\Grievance\Service\GrievanceSettingAdminService;

class GrievanceSettingForm extends Component
{
    use SessionFlash;

    public ?GrievanceSetting $grievanceSetting;
    public ?Action $action;
    public $users = [];

    public function rules(): array
    {
        return [
            'grievanceSetting.grievance_assigned_to' => ['required', 'integer'],
            'grievanceSetting.escalation_days' => ['required', 'integer'],
        ];
    }
    public function messages(): array
    {
        return [
            'grievanceSetting.grievance_assigned_to.required' => __('grievance::grievance.grievance_assigned_to_is_required'),
            'grievanceSetting.grievance_assigned_to.integer' => __('grievance::grievance.grievance_assigned_to_must_be_an_integer'),
            'grievanceSetting.escalation_days.required' => __('grievance::grievance.escalation_days_is_required'),
            'grievanceSetting.escalation_days.integer' => __('grievance::grievance.escalation_days_must_be_an_integer'),
        ];
    }


    public function render()
    {
        return view("Grievance::livewire.grievanceSetting.form",);
    }

    public function mount(GrievanceSetting $grievanceSetting, Action $action): void
    {
        $this->grievanceSetting = $grievanceSetting;
        $this->action = $action;
        $this->users = User::pluck('name', 'id')->toArray();
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = GrievanceSettingAdminDto::fromLiveWireModel($this->grievanceSetting);
            $service = new GrievanceSettingAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('grievance::grievance.grievance_setting_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->grievanceSetting, $dto);
                    $this->successFlash(__('grievance::grievance.grievance_setting_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.grievance.setting');
        }catch (\Throwable $e){
            logger($e->getMessage());
           $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

}
