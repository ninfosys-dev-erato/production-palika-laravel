<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Meetings\DTO\DecisionAdminDto;
use Src\Meetings\Models\Decision;
use Src\Meetings\Service\DecisionAdminService;

class DecisionForm extends Component
{
    use SessionFlash, HelperDate;

    public ?Decision $decision;
    public ?Action $action;
    public $meetingId;

    public function rules(): array
    {
        return [
            'decision.meeting_id' => ['required', 'integer', 'exists:met_meetings,id,deleted_at,NULL'],
            'decision.date' => ['required', 'string'],
            'decision.chairman' => ['required', 'string'],
            'decision.description' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'decision.meeting_id.required' => __('The meeting ID is required.'),
            'decision.meeting_id.integer' => __('The meeting ID must be an integer.'),
            'decision.meeting_id.exists' => __('The selected meeting ID is invalid.'),
            'decision.date.required' => __('The date is required.'),
            'decision.date.string' => __('The date must be a string.'),
            'decision.chairman.required' => __('The chairman is required.'),
            'decision.chairman.string' => __('The chairman must be a string.'),
            'decision.description.required' => __('The description is required.'),
            'decision.description.string' => __('The description must be a string.'),
        ];
    }

    public function render()
    {
        return view("Meetings::livewire.decision-form");
    }

    public function mount(Decision $decision, Action $action, $meetingId)
    {
        $this->decision = $decision;
        $this->action = $action;
        $this->meetingId = $meetingId;
        if (empty($decision->meeting_id)) {
            $this->decision['meeting_id'] = $meetingId;
        }
    }
    public function updated()
    {
        $this->skipRender();
        $this->validate();
    }
    public function save()
    {
        $this->validate();
        try{
            $this->decision['en_date'] = $this->bsToAd($this->decision['date']);
            $dto = DecisionAdminDto::fromLiveWireModel($this->decision);
            $service = new DecisionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Decision Created Successfully"));
                case Action::UPDATE:
                    $service->update($this->decision, $dto);
                    $this->successFlash(__("Decision Updated Successfully"));
                default:
            }
            return redirect()->route('admin.meetings.manage', $this->decision['meeting_id']);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
