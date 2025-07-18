<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Meetings\DTO\MinuteAdminDto;
use Src\Meetings\Models\Minute;
use Src\Meetings\Service\MinuteAdminService;

class MinuteForm extends Component
{
    use SessionFlash;

    public ?Minute $minute;
    public ?Action $action;
    public ?int $meetingId;

    public function rules(): array
    {
        return [
            'minute.description' => ['nullable'],
        ];
    }


    public function render()
    {
        return view("Meetings::livewire.minute-form",);
    }

    public function updated()
    {
        $this->skipRender();
        $this->validate();
    }

    public function mount(Minute $minute, Action $action, int $meetingId): void
    {
        $this->minute = $minute;
        $this->action = $action;
        $this->meetingId = $meetingId;
        if (empty($this->minute->meeting_id)) {
            $this->minute['meeting_id'] = $meetingId;
        }
    }

    public function save()
    {
        $this->validate();
        if (empty($this->minute->meeting_id)) {
            $this->minute->meeting_id = $this->meetingId;
        }
        try {
            $dto = MinuteAdminDto::fromLiveWireModel($this->minute);
            $service = new MinuteAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Minute Created Successfully"));
                    break;
                case Action::UPDATE:
                    $service->update($this->minute, $dto);
                    $this->successFlash(__("Minute Updated Successfully"));
                    break;
            }
            return redirect()->route('admin.meetings.manage',  $this->minute['meeting_id']);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
