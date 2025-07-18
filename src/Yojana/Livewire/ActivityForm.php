<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ActivityAdminDto;
use Src\Yojana\Models\Activity;
use Src\Yojana\Models\ProjectActivityGroup;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ActivityAdminService;
use Livewire\Attributes\On;

class ActivityForm extends Component
{
    use SessionFlash;

    public ?Activity $activity;
    public ?Action $action = Action::CREATE;
    public $projectActivityGroups;
    public $units;

    public function rules(): array
    {
        return [
            'activity.title' => ['required'],
            'activity.group_id' => ['required'],
            'activity.code' => ['required'],
            'activity.ref_code' => ['required'],
            'activity.unit_id' => ['required'],
            'activity.qty_for' => ['required'],
            'activity.will_be_in_use' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'activity.title.required' => __('yojana::yojana.title_is_required'),
            'activity.group_id.required' => __('yojana::yojana.group_id_is_required'),
            'activity.code.required' => __('yojana::yojana.code_is_required'),
            'activity.ref_code.required' => __('yojana::yojana.ref_code_is_required'),
            'activity.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'activity.qty_for.required' => __('yojana::yojana.qty_for_is_required'),
            'activity.will_be_in_use.nullable' => __('yojana::yojana.will_be_in_use_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.activities.form");
    }

    public function mount(Activity $activity, Action $action)
    {
        $this->activity = $activity;
        $this->action = $action;
        $this->projectActivityGroups =  ProjectActivityGroup::whereNull('deleted_at')->pluck('title', 'id');
        $this->units =  Unit::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ActivityAdminDto::fromLiveWireModel($this->activity);
        $service = new ActivityAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.activity_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.activities.index');
                break;
            case Action::UPDATE:
                $service->update($this->activity, $dto);
                $this->successFlash(__('yojana::yojana.activity_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.activities.index');
                break;
            default:
                return redirect()->route('admin.activities.index');
                break;
        }
    }
    #[On('edit-activity')]
    public function activity(Activity $activity)
    {
        $this->activity = $activity;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['activity', 'action']);
        $this->activity = new Activity();
    }
}
