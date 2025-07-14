<?php

namespace Src\ActivityLogs\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\ActivityLogs\Controllers\ActivityLogAdminController;
use Src\ActivityLogs\DTO\ActivityLogAdminDto;
use Src\ActivityLogs\Models\ActivityLog;
use Src\ActivityLogs\Service\ActivityLogAdminService;

class ActivityLogForm extends Component
{
    use SessionFlash;

    public ?ActivityLog $activityLog;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'activityLog.log_name' => ['required'],
    'activityLog.description' => ['required'],
    'activityLog.subject_type' => ['required'],
    'activityLog.event' => ['required'],
    'activityLog.subject_id' => ['required'],
    'activityLog.causer_type' => ['required'],
    'activityLog.causer_id' => ['required'],
    'activityLog.properties' => ['required'],
    'activityLog.batch_uuid' => ['required'],
];
    }

    public function render(){
        return view("ActivityLogs::livewire.form");
    }

    public function mount(ActivityLog $activityLog,Action $action)
    {
        $this->activityLog = $activityLog;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ActivityLogAdminDto::fromLiveWireModel($this->activityLog);
        $service = new ActivityLogAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Activity Log Created Successfully");
                return redirect()->route('admin.activity_logs.index');
                break;
            case Action::UPDATE:
                $service->update($this->activityLog,$dto);
                $this->successFlash("Activity Log Updated Successfully");
                return redirect()->route('admin.activity_logs.index');
                break;
            default:
                return redirect()->route('admin.activity_logs.index');
                break;
        }
    }
}
