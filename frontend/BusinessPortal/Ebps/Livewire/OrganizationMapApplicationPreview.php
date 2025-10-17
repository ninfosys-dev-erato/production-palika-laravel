<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

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

class OrganizationMapApplicationPreview extends Component
{
    use SessionFlash;
    public ?MapApplyStep $mapApplyStep = null;

    public $mapApplySteps;
    public $letters;
    public array $mapApplyStatusEnum = [];
    public ?string $selectedStatus;
    public ?string $reason;
    public ?string $letter = null;
    public $files;
    public bool $openStatusModal = false;

    public function render(){
        return view("BusinessPortal.Ebps::livewire.preview");
    }

    public function mount(MapApplyStep $mapApplyStep)
    {
        $this->mapApplyStep = $mapApplyStep;

        $mapStepId = $mapApplyStep->map_step_id;
        $mapApplyId = $mapApplyStep->map_apply_id;

        $this->mapApplySteps = MapApplyStep::with('mapApplyStepTemplates')
            ->where('map_apply_id', $mapApplyId)
            ->where('map_step_id', $mapStepId)
            ->get();

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

        $this->selectedStatus = $mapApplyStep->status;
        $this->mapApplyStatusEnum = MapApplyStatusEnum::cases();

        $this->files = BuildingRegistrationDocument::where('map_step_id', $mapStepId)
            ->where('map_apply_id', $mapApplyId)
            ->whereNull('deleted_at')
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
        $this->dispatch('print-certificate-letter', id: $mapApplyStepTemplate->id);
    }

}
