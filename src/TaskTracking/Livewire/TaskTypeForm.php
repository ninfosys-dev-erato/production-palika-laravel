<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TaskTypes\Controllers\TaskTypeAdminController;
use Src\TaskTracking\DTO\TaskTypeAdminDto;
use Src\TaskTracking\Models\TaskType;
use Src\TaskTracking\Service\TaskTypeAdminService;

class TaskTypeForm extends Component
{
    use SessionFlash;

    public ?TaskType $taskType;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'taskType.type_name' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'taskType.type_name.required' => __('tasktracking::tasktracking.the_task_type_name_is_required'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.task-type.form");
    }

    public function mount(TaskType $taskType,Action $action)
    {
        $this->taskType = $taskType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = TaskTypeAdminDto::fromLiveWireModel($this->taskType);
            $service = new TaskTypeAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tasktracking::tasktracking.task_type_created_successfully'));
                    return redirect()->route('admin.task-types.index');
                case Action::UPDATE:
                    $service->update($this->taskType,$dto);
                    $this->successFlash(__('tasktracking::tasktracking.task_type_updated_successfully'));
                    return redirect()->route('admin.task-types.index');
                default:
                    return redirect()->route('admin.task-types.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('tasktracking::tasktracking.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
