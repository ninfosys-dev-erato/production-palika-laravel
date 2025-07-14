<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Grievance\DTO\GrievanceDetailAdminDto;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Service\GrievanceService;

class GrievanceDetailGrievancePriority extends Component
{
    use SessionFlash;

    public ?GrievanceDetail $grievanceDetail;
    public Action $action;
    public $users = [];

    public function rules(): array
    {
        return [
            'grievanceDetail.priority' => ['required', Rule::in(GrievancePriorityEnum::cases())]
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceDetail.grievancePriority");
    }

    public function mount(GrievanceDetail $grievanceDetail): void
{
    $this->grievanceDetail = $grievanceDetail;
    $this->action = Action::UPDATE;
}


    public function save()
    {
        $this->validate();
        try{
            $dto = GrievanceDetailAdminDto::fromLiveWireModel($this->grievanceDetail, null, null);

            $service = new GrievanceService();
            switch ($this->action) {
                case Action::UPDATE:
                    $service->updatePriority($this->grievanceDetail, $dto);
                    $this->successFlash(__('grievance::grievance.grievance_detail_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.grievance.grievanceDetail.show', $this->grievanceDetail->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
           $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}

