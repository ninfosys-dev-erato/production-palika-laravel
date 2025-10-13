<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\Models\FormType;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\UpdatedTemplateDetail;
use Src\Ejalas\Enum\FormTypeEnum;
use Src\Ejalas\Traits\EjalashTemplateTrait;
use Illuminate\Support\Facades\Auth;



class AnusuchiFormPreview extends Component
{
    use SessionFlash, HelperDate, EjalashTemplateTrait;

    public ?ComplaintRegistration $complaintRegistration;
    public $formTemplate = [];
    public $formTemplateId;
    public $certificateTemplate;
    public $style;
    public $preview = true;
    public $editMode = false;
    public $hasUnsavedChanges = false;
    public function rules(): array
    {
        return [
            'formTemplateId' => ['required'],
        ];
    }


    public function messages(): array
    {
        return [
            'formTemplateId.required' => __('ejalas::ejalas.form_template_id_is_required'),
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.anusuchi-form.preview");
    }

    public function mount(ComplaintRegistration $complaintRegistration)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->formTemplate = FormType::whereNull('deleted_at')->where('status', true)->where('form_type', FormTypeEnum::ANUSUCHI)->pluck('name','id');
        $this->editMode = !$this->preview;
        $this->hasUnsavedChanges = false;
    }
 
    public function getFormTemplate()
    {
        // fetch the FormType model with its relation
        $formType = FormType::with('form')->find($this->formTemplateId);

        if (!$formType || !$formType->form) {
            $this->errorToast(__('ejalas::ejalas.form_not_found'));
            return;
        }

        // Check if there's an existing updated template
        $existingTemplate = UpdatedTemplateDetail::where('complaint_registration_id', $this->complaintRegistration->id)
            ->where('form_id', $formType->form->id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingTemplate) {
            $this->certificateTemplate = $existingTemplate->template;
            $this->style = ''; 
        } else {
            $resolved = $this->resolveEjalasTemplate($this->complaintRegistration, $formType->form?->title);
            $this->certificateTemplate = $resolved['template'];
            $this->style = $resolved['styles'];
        }
        $this->preview = true;
        $this->editMode = false;
    }

public function updatedCertificateTemplate()
{
    $this->hasUnsavedChanges = true;
}
    public function togglePreview()
    {
        $this->preview = !$this->preview;
        $this->editMode = !$this->preview; 
        $this->dispatch('update-editor', ['certificateTemplate' => $this->certificateTemplate]);


    }

    public function saveTemplate()
    {
        
        if (!$this->formTemplateId || !$this->certificateTemplate) {
            $this->errorToast(__('ejalas::ejalas.form_template_id_is_required'));
            return;
        }

        $formType = FormType::with('form')->find($this->formTemplateId);
        if (!$formType || !$formType->form) {
            $this->errorToast(__('ejalas::ejalas.form_not_found'));
            return;
        }
        $fullTemplate = $this->certificateTemplate;
        if (!empty($this->style)) {
            $fullTemplate = $this->certificateTemplate . $this->style ;
        }
        // Update or create the template detail
        UpdatedTemplateDetail::updateOrCreate(
            [
                'complaint_registration_id' => $this->complaintRegistration->id,
                'form_id' => $formType->form->id,
                'deleted_at' => null
            ],
            [
                'template' => $fullTemplate,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['certificateTemplate' => $this->certificateTemplate]);
        $this->successToast(__('ejalas::ejalas.template_saved_successfully'));
    }

    public function resetTemplate()
    {
        if (!$this->formTemplateId) {
            $this->errorToast(__('ejalas::ejalas.form_template_id_is_required'));
            return;
        }

        $formType = FormType::with('form')->find($this->formTemplateId);
        if (!$formType || !$formType->form) {
            $this->errorToast(__('ejalas::ejalas.form_not_found'));
            return;
        }

        $existingTemplate = UpdatedTemplateDetail::where('complaint_registration_id', $this->complaintRegistration->id)
    ->where('form_id', $formType->form->id)
    ->whereNull('deleted_at')
    ->first();

    if ($existingTemplate) {
        $existingTemplate->deleted_at = now();
        $existingTemplate->deleted_by = auth()->id();
        $existingTemplate->save();
    }
        $resolved = $this->resolveEjalasTemplate($this->complaintRegistration, $formType->form?->title);
        $this->certificateTemplate = $resolved['template'];
        $this->style = $resolved['styles'];

        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['certificateTemplate' => $this->certificateTemplate]);
        $this->successToast(__('ejalas::ejalas.template_reset_successfully'));
    }

    public function printTemplate()
    {
        // Check if there are unsaved changes
        if ($this->hasUnsavedChanges) {
            $this->errorToast(__('ejalas::ejalas.please_save_changes_before_printing'));
            return;
        }

        // If no unsaved changes, proceed with printing
        $this->dispatch('print-template');
    }
 
}
