<?php

namespace Src\Ebps\Livewire;

use Livewire\Component;
use App\Traits\SessionFlash;
use Src\Ebps\DTO\AdditionalFormDto;
use Src\Ebps\Service\AdditionalFormService;
use Src\Ebps\Models\AdditionalForm;
use App\Enums\Action;
use Livewire\Attributes\On;
use Src\Settings\Models\Form;

class AdditionalFormSettingForm extends Component
{
    use SessionFlash;

    public ?AdditionalForm $additionalForm;
    public ?Action $action = Action::CREATE;
    public $forms;


    protected $rules = [
        'additionalForm.name' => 'required',
        'additionalForm.form_id' => 'required',
        'additionalForm.status' => 'nullable',
    ];

    protected $messages = [
        'additionalForm.name.required' => 'Name is required.',
        'additionalForm.form_id.required' => 'Form is required.',
    ];

    public function mount(AdditionalForm $additionalForm, $action)
    {
        $this->action = $action;
        $this->additionalForm = $additionalForm;
        $this->forms = Form::where('module', 'ebps')->whereNull('deleted_by')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();

        try {
            $dto = AdditionalFormDto::fromLiveWireModel($this->additionalForm);
            $service = new AdditionalFormService();

            switch ($this->action) {
                case Action::CREATE:
                    $additionalForm = $service->store($dto);
                    $this->successFlash(__('ebps::ebps.additional_form_created_successfully'));
                    return redirect()->route('admin.ebps.additional_form_settings.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->additionalForm, $dto);
                    $this->successFlash(__('ebps::ebps.additional_form_updated_successfully'));
                    return redirect()->route('admin.ebps.additional_form_settings.index');
                    break;

                default:
                    return $this->redirect(url()->previous());
                    break;
            }
        } catch (\Exception $e) {
            $this->errorFlash(__('ebps::ebps.something_went_wrong_while_saving') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('Ebps::livewire.additional-form-setting.additional-form-setting-form');
    }
    #[On('edit-additional-form-setting')]
    public function editAdditionalFormSetting(AdditionalForm $additionalForm)
    {
        $this->additionalForm = $additionalForm;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['additionalForm', 'action']);
        $this->additionalForm = new AdditionalForm();
    }
    #[On('reset-form')]
    public function resetAdditionalFormSetting()
    {
        $this->resetForm();
    }
}
