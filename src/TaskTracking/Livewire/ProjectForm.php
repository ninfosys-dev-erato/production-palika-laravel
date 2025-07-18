<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Projects\Controllers\ProjectAdminController;
use Src\TaskTracking\DTO\ProjectAdminDto;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Service\ProjectAdminService;

class ProjectForm extends Component
{
    use SessionFlash;

    public ?Project $project;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'project.title' => ['required'],
            'project.description' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'project.title.required' => __('tasktracking::tasktracking.the_project_title_is_required'),
            'project.description.required' => __('tasktracking::tasktracking.the_project_description_is_required'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.project.form");
    }

    public function mount(Project $project,Action $action)
    {
        $this->project = $project;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = ProjectAdminDto::fromLiveWireModel($this->project);
            $service = new ProjectAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tasktracking::tasktracking.project_created_successfully'));
                    return redirect()->route('admin.task.projects.index');
                case Action::UPDATE:
                    $service->update($this->project,$dto);
                    $this->successFlash(__('tasktracking::tasktracking.project_updated_successfully'));
                    return redirect()->route('admin.task.projects.index');
                default:
                    return redirect()->route('admin.task.projects.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('tasktracking::tasktracking.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
