<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Meetings\DTO\AgendaAdminDto;
use Src\Meetings\Models\Agenda;
use Src\Meetings\Service\AgendaAdminService;

class AgendaForm extends Component
{
    use SessionFlash;

    public ?Agenda $agenda;
    public ?Action $action;
    public $meetingId;
    public function rules(): array
    {
        return [
            'agenda.meeting_id' => ['required', 'string'],
            'agenda.proposal' => ['required', 'string'],
            'agenda.description' => ['required', 'string'],
            'agenda.is_final' => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array
{
    return [
        'agenda.meeting_id.required' => __('The meeting ID is required.'),
        'agenda.meeting_id.string' => __('The meeting ID must be a string.'),
        
        'agenda.proposal.required' => __('The proposal field is required.'),
        'agenda.proposal.string' => __('The proposal must be a string.'),
        
        'agenda.description.required' => __('The description field is required.'),
        'agenda.description.string' => __('The description must be a string.'),
        
        'agenda.is_final.boolean' => __('The is final field must be true or false.'),
    ];
}


    public function render()
    {
        return view("Meetings::livewire.agenda-form");
    }

    public function mount(Agenda $agenda, Action $action, $meetingId)
    {
        $this->agenda = $agenda;
        $this->action = $action;
        $this->meetingId = $meetingId;

        if (empty($agenda->meeting_id)){
            $this->agenda['meeting_id'] = $this->meetingId ;
        }
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = AgendaAdminDto::fromLiveWireModel($this->agenda);
            $service = new AgendaAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Agenda Created Successfully"));
                    break;
                case Action::UPDATE:
                    $service->update($this->agenda, $dto);
                    $this->successFlash(__("Agenda Updated Successfully"));
                    break;
                default:
                    break;
            }
            return redirect()->route('admin.meetings.manage', $this->agenda['meeting_id']);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}