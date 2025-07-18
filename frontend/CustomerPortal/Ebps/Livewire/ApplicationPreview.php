<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\BuildingRegistrationDocument;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Service\MapApplyAdminService;
use Livewire\Attributes\On;

class ApplicationPreview extends Component
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
        return view("CustomerPortal.Ebps::livewire.preview");
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

        $this->selectedStatus = $mapApplyStep->status;
        $this->mapApplyStatusEnum = MapApplyStatusEnum::cases();

        $this->files = BuildingRegistrationDocument::where('map_step_id', $mapStepId)->where('map_apply_id', $mapApplyId)->get();

    }


    #[On('print-map-apply')]
    public function print(MapApplyStepTemplate $mapApplyStepTemplate)
    {
        $service = new MapApplyAdminService();
        return $service->getLetter($mapApplyStepTemplate,'web');
    }

}
