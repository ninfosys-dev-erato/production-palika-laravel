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

class MapApplyPreview extends Component
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
        return view("Ebps::livewire.map-applies.map-applies-preview");
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

    public function changeStatus()
    {
        $this->openStatusModal = !$this->openStatusModal;
    }

    public function saveStatus()
    {
        try{
           
            foreach ($this->mapApplySteps as $step) {

                foreach ($step->mapApplyStepTemplates as $template) {
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
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('print-map-apply')]
    public function print(MapApplyStepTemplate $mapApplyStepTemplate)
    {
        $service = new MapApplyAdminService();
        return $service->getLetter($mapApplyStepTemplate,'web');
    }

}
