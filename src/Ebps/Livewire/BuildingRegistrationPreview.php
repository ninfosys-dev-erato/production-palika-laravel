<?php

namespace Src\Ebps\Livewire;

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
use Src\Ebps\Service\MapApplyStepApproverAdminService;

class BuildingRegistrationPreview extends Component
{
    use SessionFlash;
    public ?MapApplyStep $mapApplyStep;
    public  $letters;
    public array $mapApplyStatusEnum = [];
    public ?string $selectedStatus;
    public ?string $reason;
    public ?string $letter = null;

    public bool $openStatusModal = false;
    public $files;

    public $mapApplySteps;
    public $additionalForms;

    public function render()
    {
        return view("Ebps::livewire.map-applies.map-applies-preview");
    }
    public function mount(MapApplyStep $mapApplyStep)
    {
        $this->mapApplyStep = $mapApplyStep;
        $mapStepId = $mapApplyStep->map_step_id;
        $mapApplyId = $mapApplyStep->map_apply_id;

        // ✅ Eager load everything you need
        $this->mapApplySteps = MapApplyStep::with([
            'mapApplyStepTemplates',
            'mapApply.additionalFormDynamicData.form.additionalForm',
            'mapStep' // 👈 eager load this
        ])
            ->where('map_apply_id', $mapApplyId)
            ->where('map_step_id', $mapStepId)
            ->get();

        // // Flatten templates
        // $this->letters = $this->mapApplySteps->flatMap(function ($step) {
        //     return $step->mapApplyStepTemplates;
        // });

         $this->letters = $this->mapApplySteps->flatMap(function ($step) {
        return $step->mapApplyStepTemplates;
    });

    // Clean the 'template' field for each letter
    $this->letters = $this->letters->map(function ($letter) {
        if (isset($letter['template'])) {
            $letter['template'] = $this->cleanTemplate($letter['template']);
        }
        return $letter;
    });
        // Since mapApply is already eager loaded, no lazy loading problem
        $firstStep = $this->mapApplySteps->first();

        $this->additionalForms = collect(); // default empty
        if ($firstStep && $firstStep->mapApply) {
            $this->additionalForms = $firstStep->mapApply
                ->additionalFormDynamicData()
                ->whereNotNull('form_data')
                ->with(['form', 'form.additionalForm'])
                ->get();
        }

        $this->selectedStatus = $mapApplyStep->status;
        $this->mapApplyStatusEnum = MapApplyStatusEnum::cases();

        $this->files = BuildingRegistrationDocument::where('map_step_id', $mapStepId)
            ->where('map_apply_id', $mapApplyId)
            ->get();
    }

    /**
 * Clean a template string by removing empty <p> tags and placeholders
 */
private function cleanTemplate(string $template): string
{
    // Remove empty <p> tags including spaces, tabs, newlines, &nbsp; (literal or UTF-8)
    $template = preg_replace('/<p>([\s\x{00A0}&nbsp;]*)<\/p>/iu', '', $template);

    // Remove all {{...}} placeholder tags
    $template = preg_replace('/{{[^}]*}}/', '', $template);

    return trim($template);
}


    public function changeStatus()
    {
        $this->openStatusModal = !$this->openStatusModal;
    }

    public function saveStatus()
    {
        try {
            foreach ($this->mapApplyStep->mapApplyStepTemplates as $template) {
                if ($template->formid === $this->mapApplyStep->formid) {
                    if ($this->selectedStatus === "accepted") {
                        $signature = Auth::user()?->signature
                            ? '<img src="data:image/jpeg;base64,' . Auth::user()->signature . '" alt="Signature" width="80">'
                            : 'No Signature Available';
                        $this->letter = Str::replace('{{form.approver.signature}}', $signature, $template->template);
                    }
                    $template->update([
                        'template' => $this->letter ?? $template->template,
                    ]);
                }
            }
            $this->mapApplyStep->update([
                'status' => $this->selectedStatus,
                'reason' => $this->reason ?? null,
            ]);

            $dto = MapApplyStepApproverAdminDto::fromStepAndUser(
                mapApplyStepId: $this->mapApplyStep->id,
                userId: Auth::user()->id,
                status: $this->selectedStatus,
                reason: $this->reason ?? '',
            );

            $service = new MapApplyStepApproverAdminService();
            $service->store($dto);
            $this->successFlash(__('ebps::ebps.status_updated_successfully'));
            $this->changeStatus();
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
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

    #[On('print-map-apply')]
    public function print(MapApplyStepTemplate $mapApplyStepTemplate)
    {
        // $service = new MapApplyAdminService();
        // return $service->getLetter($mapApplyStepTemplate, 'web');
        $this->dispatch('print-certificate-letter', id: $mapApplyStepTemplate->id);
    }
}
