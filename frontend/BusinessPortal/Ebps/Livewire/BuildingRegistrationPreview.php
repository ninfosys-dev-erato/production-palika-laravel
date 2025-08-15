<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Ebps\DTO\MapApplyStepApproverAdminDto;
use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\MapApplyStep;
use Illuminate\Database\Eloquent\Collection;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Service\MapApplyAdminService;
use Livewire\Attributes\On;
use Src\Ebps\Service\MapApplyStepApproverAdminService;
use Src\Ebps\Models\BuildingRegistrationDocument;

class BuildingRegistrationPreview extends Component
{
    use SessionFlash;
    public ?MapApplyStep $mapApplyStep;
    public ?Collection $letters = null;
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
        $this->letters = $this->mapApplyStep->mapApplyStepTemplates;

        $this->selectedStatus = $mapApplyStep->status;
        $this->mapApplyStatusEnum = MapApplyStatusEnum::cases();

        // Get files for this step
        $mapStepId = $mapApplyStep->map_step_id;
        $mapApplyId = $mapApplyStep->map_apply_id;

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

   

    #[On('print-map-apply')]
    public function print(MapApplyStepTemplate $mapApplyStepTemplate)
    {
        $service = new MapApplyAdminService();
        return $service->getLetter($mapApplyStepTemplate,'web');
    }

}
