<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Ejalas\DTO\FormTypeAdminDto;
use Src\Ejalas\Enum\FormTypeEnum;
use Src\Ejalas\Models\FormType;
use Src\Ejalas\Service\FormTypeAdminService;
use Src\Settings\Models\Form;
use Livewire\Attributes\On;

class FormTypeForm extends Component
{
    use SessionFlash;

    public ?FormType $formType;
    public Action $action = Action::CREATE;
    public $forms = [];
    public $formTypes = [];
    public $formTypeOptions = [];

    public function rules(): array
    {
        return [
            'formType.name' => ['required', 'string', 'max:255'],
            'formType.form_id' => ['required', 'string', ],
           
            'formType.form_type' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'formType.name.required' => __('ejalas::ejalas.the_name_is_required'),
            'formType.name.string' => __('ejalas::ejalas.the_name_must_be_a_string'),
            'formType.name.max' => __('ejalas::ejalas.the_name_must_not_exceed_255_characters'),
            'formType.form_id.required' => __('ejalas::ejalas.the_form_id_is_required'),
            'formType.form_id.string' => __('ejalas::ejalas.the_form_id_must_be_a_string'),
        
         
            
        ];
    }

    public function mount(FormType $formType, Action $action): void
    {
        $this->formType = $formType;
        $this->action = $action;
        
        $this->forms = Form::where('module', 'ejalas')->whereNull('deleted_by')->pluck('title', 'id')->toArray();
        $this->formTypeOptions = FormTypeEnum::getForWeb();
    
    }

    public function render(): View
    {
        return view("Ejalas::livewire.ejalas-form.form-type-form");
    }

    public function save()
    {
        $this->validate();

        try {
            $dto = FormTypeAdminDto::fromLiveWireModel($this->formType);
            $service = new FormTypeAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.form_type_created_successfully'));
                    return redirect()->route('admin.ejalas.form-template-type.index');

                case Action::UPDATE:
                    $service->update($this->formType, $dto);
                    $this->successFlash(__('ejalas::ejalas.form_type_updated_successfully'));
                    return redirect()->route('admin.ejalas.form-template-type.index');

                default:
                    return redirect()->route('admin.ejalas.form-template-type.index');
            }
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }

    #[On('edit-form-type')] 
    public function editFormType(FormType $formType)
    {
        $this->formType = $formType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset(['formType', 'action']);
        $this->formType = new FormType();
        $this->action = Action::CREATE;
    }
}
