<?php


namespace Src\Ejalas\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ejalas\Models\CaseRecord;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\CourtSubmission;
use Src\Ejalas\Models\DisputeDeadline;
use Src\Ejalas\Models\DisputeRegistrationCourt;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Models\HearingSchedule;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Models\MediatorSelection;
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Models\WitnessesRepresentative;
use Src\Ejalas\Models\WrittenResponseRegistration;
use Livewire\Attributes\On;
use App\Facades\PdfFacade;
use Src\Ejalas\Models\JudicialMeeting;
use Src\Ejalas\Service\TemplateAdminService;
use Src\Ejalas\Traits\EjalashTemplateTrait;

class TemplateForm extends Component
{
    use SessionFlash, WithFileUploads, EjalashTemplateTrait;


    // public bool $preview = false;
    public $letter;
    public ?ComplaintRegistration $complaintRegistration;
    public ?DisputeRegistrationCourt $disputeRegistrationCourt;
    public ?DisputeDeadline $disputeDeadline;
    public ?HearingSchedule $hearingSchedule;
    public ?WrittenResponseRegistration $writtenResponseRegistration;
    public ?MediatorSelection $mediatorSelection;
    public ?WitnessesRepresentative $witnessRepresentative;
    public ?LegalDocument $legalDocument;
    public ?Settlement $setttlement;
    public ?FulfilledCondition $fulfilledCondition;
    public ?CaseRecord $caseRecord;
    public ?CourtSubmission $courtSubmission;
    public ?JudicialMeeting $judicialMeeting;
    public $model;
    public $style;

    public function mount($model): void
    {
        $this->model = $model;
        if ($model->template) {
            $this->letter = $model->template;
            $this->style = $model->styles ?? '';
        } else {
            $resolved = $this->resolveEjalasTemplate($model, class_basename($this->model));
            $this->letter = $resolved['template'];
            $this->style = $resolved['styles'];
        }
    }

    public function resetLetter()
    {
        $this->letter = $this->resolveEjalasTemplate($this->model, class_basename($this->model));
        $this->dispatch('update-editor', ['letter' => $this->letter]);
        $this->successToast(__('ejalas::ejalas.reset_successfully'));
    }

    public function render()
    {
        return view("Ejalas::livewire.template");
    }

    public function save()
    {
        $this->model->update([
            'template' => $this->letter
        ]);

        $this->successToast(__('ejalas::ejalas.saved_successfully'));
    }

    // public function togglePreview()
    // {
    //     $this->preview = $this->preview ? false : true;
    // }

    #[On('print-ejalas-form')]
    public function print()
    {
        $service = new TemplateAdminService();
        $url =  $service->getLetter($this->letter, $this->model, $this->style);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }
}
