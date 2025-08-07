<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRequiredDocDto;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRequiredDoc;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Service\BusinessRequiredDocService;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Recommendation\Services\RecommendationService;

class BusinessRegistrationApplication extends Component
{
    use SessionFlash, BusinessRegistrationTemplate, WithFileUploads;

    public ?BusinessRegistration $businessRegistration;
    public ?BusinessRequiredDoc $businessRequiredDoc;

    public $applicationFile;
    public $applicationFileUrl;

    public $documentField;
    public string $activeTab = 'application-letter';
    public $registrationType;
    public $applicationTemplate;
    public $style;
    public $preview = true;
    public $editMode = false;
    public $applicationLetter;
    public $hasUnsavedChanges = false;

    public function rules(): array
    {
        $rules = [

            'businessRequiredDoc.document_filename' => 'required',
            'businessRequiredDoc.document_label_en' => 'required',
            'businessRequiredDoc.document_label_ne' => 'required',
            'applicationFile' => 'required',
            'applicationLetter' => 'nullable|string',
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'documentField.required' => 'Document field is required',
            'businessRequiredDoc.document_label_en.required' => 'Document label is required',
            'businessRequiredDoc.document_label_ne.required' => 'Document label is required',
            'applicationFile.required' => 'Document file is required',
        ];
    }

    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->documentField = 'application_letter';
        $this->businessRegistration = $businessRegistration;
        $this->businessRequiredDoc = new BusinessRequiredDoc();
        $this->registrationType = RegistrationType::with('form')
            ->whereNull('deleted_at')
            ->where('status', true)
            ->where('registration_category_enum', $this->businessRegistration->registration_category)
            ->where('action', BusinessRegistrationType::Application)
            ->first();

        $this->style = $this->registrationType?->form?->styles ?? "";
        $this->updateApplicationTemplate();
        $this->editMode = !$this->preview; // Initialize editMode
        $this->hasUnsavedChanges = false; // Initialize unsaved changes flag

        // Set default values for document labels
        $this->setDefaultDocumentLabels();
    }


    private function updateApplicationTemplate(): void
    {
        $template = $this->businessRegistration->application_letter ?? $this->registrationType?->form?->template ?? '';
        $this->applicationTemplate = $this->resolveTemplate($this->businessRegistration, $template);
    }

    /**
     * Set default document labels based on registration category
     */
    private function setDefaultDocumentLabels(): void
    {
        $category = $this->businessRegistration->registration_category;

        // Set default labels based on category
        switch ($category) {
            case 'business':
                $this->businessRequiredDoc->document_label_en = 'Business Application Letter';
                $this->businessRequiredDoc->document_label_ne = 'व्यवसाय निवेदन पत्र';
                break;
            case 'organization':
                $this->businessRequiredDoc->document_label_en = 'Organization Application Letter';
                $this->businessRequiredDoc->document_label_ne = 'संघ/संस्था निवेदन पत्र';
                break;
            case 'firm':
                $this->businessRequiredDoc->document_label_en = 'Firm Application Letter';
                $this->businessRequiredDoc->document_label_ne = 'फर्म निवेदन पत्र';
                break;
            case 'industry':
                $this->businessRequiredDoc->document_label_en = 'Industry Application Letter';
                $this->businessRequiredDoc->document_label_ne = 'उद्योग निवेदन पत्र';
                break;
            default:
                $this->businessRequiredDoc->document_label_en = 'Application Letter';
                $this->businessRequiredDoc->document_label_ne = 'निवेदन पत्र';
                break;
        }
    }


    public function render()
    {
        return view('BusinessRegistration::livewire.business-registration.application');
    }

    public function setActiveTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                file: $file,
                disk: "local",
                filename: ""
            );

            $this->businessRequiredDoc->{$modelField} = $save;
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                filename: $save,
                disk: 'local'
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->businessRequiredDoc->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.BusinessRegistration.businessRegistration.registration'),
                    filename: $this->businessRequiredDoc->{$modelField},
                    disk: 'local'
                );
            }
        }
    }
    public function updatedApplicationFile()
    {
        $this->handleFileUpload(
            file: $this->applicationFile,
            modelField: 'document_filename',
            urlProperty: 'applicationFileUrl'
        );
    }

    public function updatedApplicationTemplate()
    {
        // Mark that there are unsaved changes when the template is modified
        if ($this->editMode) {
            $this->hasUnsavedChanges = true;
        }
    }
    public function togglePreview()
    {
        $this->preview = !$this->preview;
        $this->editMode = !$this->preview; // editMode is opposite of preview

    }

    public function writeApplicationLetter()
    {
        $this->businessRegistration->application_letter = $this->applicationTemplate;
        $this->businessRegistration->save();
        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['applicationTemplate' => $this->applicationTemplate]);
        $this->successToast(__('businessregistration::businessregistration.application_letter_written_successfully'));
    }
    public function resetLetter()
    {
        $this->businessRegistration->application_letter = null;
        $this->businessRegistration->save();
        $this->updateApplicationTemplate();
        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['applicationTemplate' => $this->applicationTemplate]);
        $this->successToast(__('businessregistration::businessregistration.application_letter_reset_successfully'));
    }

    public function printApplicationLetter()
    {

        // Check if there are unsaved changes
        if ($this->hasUnsavedChanges) {
            $this->errorToast(__('businessregistration::businessregistration.please_save_changes_before_printing'));
            return;
        }

        // If no unsaved changes, proceed with printing
        $this->dispatch('print-application-letter');
    }

    public function saveApplicationLetter()
    {
        $this->validate();
        $dto = BusinessRequiredDocDto::fromComponent($this);

        $service = new BusinessRequiredDocService();
        $service->store($dto);
        $this->resetForm();

        $this->successToast(__('businessregistration::businessregistration.application_letter_uploaded_successfully'));
    }
    public function resetForm()
    {
        $this->businessRequiredDoc = new BusinessRequiredDoc();
        $this->applicationFile = null;
        $this->applicationFileUrl = '';

        // Reset to default labels after clearing the form
        $this->setDefaultDocumentLabels();
    }
}
