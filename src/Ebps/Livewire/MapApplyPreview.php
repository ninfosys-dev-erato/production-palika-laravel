<?php

namespace Src\Ebps\Livewire;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperTemplate;
use App\Traits\MapApplyTrait;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Ebps\DTO\MapApplyStepApproverAdminDto;
use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\BuildingRegistrationDocument;
use Src\Ebps\Models\MapApplyStep;
use Illuminate\Database\Eloquent\Collection;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Service\MapApplyAdminService;
use Livewire\Attributes\On;
use Src\Ebps\Models\AdditionalFormDynamicData;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Service\MapApplyStepApproverAdminService;

class MapApplyPreview extends Component
{
    use SessionFlash, HelperTemplate, MapApplyTrait;
    public ?MapApplyStep $mapApplyStep = null;

    public $mapApplySteps;
    public $letters;
    public array $mapApplyStatusEnum = [];
    public ?string $selectedStatus;
    public ?string $reason;
    public ?string $letter = null;
    public $files;
    public bool $openStatusModal = false;
    public $additionalForms;
    public $placeholders = [];

    public function render()
    {
        return view("Ebps::livewire.map-applies.map-applies-preview");
    }

    public function mount(MapApplyStep $mapApplyStep)
    {
        $this->mapApplyStep = $mapApplyStep;

        $mapStepId = $mapApplyStep->map_step_id;
        $mapApplyId = $mapApplyStep->map_apply_id;

        $this->mapApplySteps = MapApplyStep::with('mapApplyStepTemplates', 'mapStep', 'mapApply', 'mapApply.additionalFormDynamicData')
            ->where('map_apply_id', $mapApplyId)
            ->where('map_step_id', $mapStepId)
            ->get();
        $this->additionalForms = $this->mapApplySteps->first()
            ->mapApply
            ->additionalFormDynamicData()
            ->whereNotNull('form_data')
            ->with(['form', 'form.additionalForm'])
            ->get();


        $this->letters = $this->mapApplySteps->flatMap(function ($step) {
            return $step->mapApplyStepTemplates;
        });

        $this->selectedStatus = $mapApplyStep->status;
        $this->mapApplyStatusEnum = MapApplyStatusEnum::cases();

        $this->files = BuildingRegistrationDocument::where('map_step_id', $mapStepId)
            ->where('map_apply_id', $mapApplyId)
            ->whereNull('deleted_at')
            ->get();
    }

    public function deleteFile($fileId)
    {
        try {
            $file = BuildingRegistrationDocument::findOrFail($fileId);

            $file->update([
                'deleted_at' => now(),
            ]);

            // Refresh the files collection to exclude the deleted file
            $this->files = BuildingRegistrationDocument::where('map_step_id', $this->mapApplyStep->map_step_id)
                ->where('map_apply_id', $this->mapApplyStep->map_apply_id)
                ->whereNull('deleted_at')
                ->get();

            $this->successFlash(__('ebps::ebps.file_deleted_successfully'));
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(__('ebps::ebps.something_went_wrong_while_deleting_file'));
        }
    }

    public function changeStatus()
    {
        $this->openStatusModal = !$this->openStatusModal;
    }

    public function saveStatus()
    {
        try {

            foreach ($this->mapApplySteps as $step) {

                foreach ($step->mapApplyStepTemplates as $template) {
                    if ($this->selectedStatus === "accepted") {
                        $signature = 'सहि फेला परेन ';

                        if (Auth::user()?->signature) {

                            $signatureContent = FileFacade::getFile(
                                config('src.Profile.profile.path'),
                                Auth::user()->signature,
                            );

                            if ($signatureContent !== false) {
                                $base64 = base64_encode($signatureContent);
                                $signature = '<img src="data:image/jpeg;base64,' . $base64 . '" alt="Signature" width="80">';
                            }
                        }
                        $this->letter = Str::replace('{{form.approver.signature}}', $signature, $template->template);
                    }
                    $template->update([
                        'template' => $this->letter ?? $template->template,
                    ]);
                }

                $step->update([
                    'status' => $this->selectedStatus,
                    'reason' => $this->reason ?? null,
                ]);
                $dto = MapApplyStepApproverAdminDto::fromStepAndUser(
                    mapApplyStepId: $step->id,
                    userId: Auth::user()->id,
                    status: $this->selectedStatus,
                    reason: $this->reason ?? '',
                );

                $service = new MapApplyStepApproverAdminService();
                $service->store($dto);
            }

            $this->successFlash(__('ebps::ebps.status_updated_successfully'));
            $this->changeStatus();
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('print-map-apply')]
    public function print(MapApplyStepTemplate $mapApplyStepTemplate)
    {
        $service = new MapApplyAdminService();
        return $service->getLetter($mapApplyStepTemplate, 'web');
    }

    public function viewAdditionalForm($additionalFormId)
    {
        $additionalForm = AdditionalFormDynamicData::with(['form', 'mapApply'])
            ->findOrFail($additionalFormId);
        $styles = $additionalForm->form->styles;

        $submittedDynamicData = json_decode($additionalForm->form_data, true) ?? [];
        $this->placeholders = $submittedDynamicData;


        $template = $this->resolveMapStepTemplate(
            $additionalForm->mapApply,
            null,
            $additionalForm->form,
            $submittedDynamicData
        );

        $template = $this->replaceInputFieldsWithValues($template);
        $service = new MapApplyAdminService();
        $url = $service->getAdditionalFormLetter($template, $styles);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    private function replaceInputFieldsWithValues($template)
    {
        return preg_replace_callback('/<input[^>]*wire:model\.defer="placeholders\.([^"]+)"[^>]*>/', function ($matches) {
            $fieldName = $matches[1];
            $value = $this->placeholders[$fieldName] ?? '';

            // Return just the value as plain text
            return e($value ?: '________________');
        }, $template);
    }
}
