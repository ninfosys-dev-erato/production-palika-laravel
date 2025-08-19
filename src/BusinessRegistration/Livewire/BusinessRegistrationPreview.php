<?php

namespace Src\BusinessRegistration\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\BusinessRegistration\DTO\CertificatePratilipiLogDto;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Recommendation\Services\RecommendationService;
use Src\BusinessRegistration\Models\CertificatePratilipiLog;
use Src\BusinessRegistration\Service\CertificatePratilipiLogService;

class BusinessRegistrationPreview extends Component
{
    use SessionFlash, BusinessRegistrationTemplate;
    public ?BusinessRegistration $businessRegistration;
    public ?CertificatePratilipiLog $certificatePratilipiLog;

    public $certificateTemplate;
    public $style;
    public $preview = true;
    public $editMode = false;
    public $hasUnsavedChanges = false;

    public function rules()
    {
        return [
            'certificatePratilipiLog.damage_reason' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [];
    }

    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->certificatePratilipiLog = new CertificatePratilipiLog();

        $this->style = $this->businessRegistration->registrationType->form?->styles ?? "";
        $this->getCertificateTemplate();
        $this->editMode = !$this->preview;
        $this->hasUnsavedChanges = false;
    }

    private function getCertificateTemplate(): void
    {
        $this->certificateTemplate = $this->businessRegistration->certificate_letter ?? $this->resolveTemplate($this->businessRegistration) ?? '';
    }

    public function render()
    {
        return view('BusinessRegistration::livewire.business-registration.preview');
    }

    // #[On('print-preview-business')]
    public function print()
    {
        $service = new BusinessRegistrationAdminService();
        return $service->getLetter($this->businessRegistration, 'web');
    }

    public function updatedCertificateTemplate()
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

    public function writeCertificateLetter()
    {
        $this->businessRegistration->certificate_letter = $this->certificateTemplate;
        $this->businessRegistration->save();
        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['certificateTemplate' => $this->certificateTemplate]);
        $this->successToast(__('businessregistration::businessregistration.certificate_letter_written_successfully'));
    }

    public function resetLetter()
    {
        $this->businessRegistration->certificate_letter = null;
        $this->businessRegistration->save();
        $this->getCertificateTemplate();
        $this->preview = true;
        $this->editMode = false;
        $this->hasUnsavedChanges = false;
        $this->dispatch('update-editor', ['certificateTemplate' => $this->certificateTemplate]);
        $this->successToast(__('businessregistration::businessregistration.certificate_letter_reset_successfully'));
    }

    public function printCertificateLetter()
    {
        // Check if there are unsaved changes
        if ($this->hasUnsavedChanges) {
            $this->errorToast(__('businessregistration::businessregistration.please_save_changes_before_printing'));
            return;
        }

        // If no unsaved changes, proceed with printing
        $this->dispatch('print-certificate-letter');
    }
    public function pratilipiEntry()
    {
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetPratilipiEntry()
    {
        $this->reset(['certificatePratilipiLog']);
        $this->certificatePratilipiLog = new CertificatePratilipiLog();
    }
    public function savePratilipiEntry()
    {
        try {
            $this->validate();

            $this->certificatePratilipiLog->business_registration_id = $this->businessRegistration->id;

            $dto = CertificatePratilipiLogDto::fromLiveWireModel($this->certificatePratilipiLog);
            $service = new CertificatePratilipiLogService();
            $service->store($dto);

            $this->resetPratilipiEntry();
            $this->dispatch('close-modal');
            $this->resetLetter();

            $this->successToast(__('businessregistration::businessregistration.pratilipi_entry_saved_successfully'));
        } catch (\Exception $e) {

            $this->errorToast(__('businessregistration::businessregistration.failed_to_save_pratilipi_entry'));
        }
    }
}
