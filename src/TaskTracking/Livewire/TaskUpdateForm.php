<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Models\User;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\TaskTracking\DTO\ActivityAdminDto;
use Src\TaskTracking\DTO\AttachmentAdminDto;
use Src\TaskTracking\DTO\TaskAdminDto;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Models\TaskType;
use Src\TaskTracking\Service\ActivityAdminService;
use Src\TaskTracking\Service\AttachmentAdminService;
use Src\TaskTracking\Service\TaskAdminService;

class TaskUpdateForm extends Component
{
    use SessionFlash, HelperDate, WithFileUploads;

    public ?Task $task;
    public ?Action $action;

    public $projects = [];
    public $taskTypes = [];
    public $availableAssigneeTypes = [];
    public $availableReporterTypes = [];
    public $users = [];
    public $reporters = [];
    public $attachments = [];
    public $files = [];

    public function rules(): array
    {
        return [
            'task.project_id' => ['required'],
            'task.task_type_id' => ['required'],
            'task.task_no' => ['required'],
            'task.title' => ['required'],
            'task.description' => ['required'],
            'task.status' => ['required'],
            'task.assignee_type' => ['required'],
            'task.assignee_id' => ['required'],
            'task.reporter_type' => ['required'],
            'task.reporter_id' => ['required'],
            'task.start_date' => ['required'],
            'task.end_date' => ['required'],
            'files.*.file' => __('tasktracking::tasktracking.each_file_must_be_a_valid_file'),
           'files.*.mimes' => __('tasktracking::tasktracking.the_file_must_be_a_pdf_doc_docx_jpg_jpeg_or_png'),
           'files.*.max' => __('tasktracking::tasktracking.the_file_must_not_exceed_2mb_in_size'),
        ];
    }

    public function messages(): array
    {
        return [
            'task.project_id.required' => __('tasktracking::tasktracking.the_project_id_is_required'),
            'task.task_type_id.required' => __('tasktracking::tasktracking.the_task_type_id_is_required'),
            'task.task_no.required' => __('tasktracking::tasktracking.the_task_number_is_required'),
            'task.title.required' => __('tasktracking::tasktracking.the_task_title_is_required'),
            'task.description.required' => __('tasktracking::tasktracking.the_task_description_is_required'),
            'task.status.required' => __('tasktracking::tasktracking.the_task_status_is_required'),
            'task.assignee_type.required' => __('tasktracking::tasktracking.the_assignee_type_is_required'),
            'task.assignee_id.required' => __('tasktracking::tasktracking.the_assignee_id_is_required'),
            'task.reporter_type.required' => __('tasktracking::tasktracking.the_reporter_type_is_required'),
            'task.reporter_id.required' => __('tasktracking::tasktracking.the_reporter_id_is_required'),
            'task.start_date.required' => __('tasktracking::tasktracking.the_start_date_is_required'),
            'task.end_date.required' => __('tasktracking::tasktracking.the_end_date_is_required'),
            'files.*.file' => __('tasktracking::tasktracking.each_file_must_be_a_valid_file'),
            'files.*.mimes' => __('tasktracking::tasktracking.the_file_must_be_a_pdf_doc_docx_jpg_jpeg_or_png'),
            'files.*.max' => __('tasktracking::tasktracking.the_file_must_not_exceed_2mb_in_size'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.task.update-form");
    }

    public function mount(Task $task,Action $action)
    {
        $this->task = $task;
        $this->action = $action;
        $this->projects = Project::select('id', 'title')
            ->whereNull('deleted_at')
            ->get();
        $this->taskTypes = TaskType::select('id', 'type_name')
            ->whereNull('deleted_at')
            ->get();

        $this->availableAssigneeTypes = [
            User::class => 'User', 
        ];
        $this->availableReporterTypes = [
            User::class => 'User', 
        ];

        if($this->action == Action::UPDATE)
        {
            $this->loadAssigne();
            $this->loadReporter();
            $this->task->start_date =$this->convertEnglishToNepali($this->task->start_date);
            $this->task->end_date =$this->convertEnglishToNepali($this->task->end_date);
        }

    }

    public function loadAssigne()
    {

        if ($this->task->assignee_type === User::class) {
            $this->users = User::whereNull(columns: 'deleted_at')->get();
           
        } else {
            $this->users = [];
            $this->task->assignee_id = null;
        }

    }

    public function loadReporter()
    {
        if ($this->task->reporter_type === User::class) {
            $this->reporters = User::whereNull('deleted_at')->get(); 
        } else {
            $this->reporters = [];
            $this->task->reporter_id = null;
        }
     
    }

    public function assignTaskNo()
    {
        if (!$this->task->project_id) {
            $this->task->task_no = null;
            return;
        }
    
        $project = Project::find($this->task->project_id);
    
        if ($project) {
            $words = explode(' ', $project->title);
    
            $initials = collect($words)
                ->map(function ($word) {
                    if (strlen($word) > 0) {
                        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8');
                    }
                    return '';
                })
                ->join('');
       
            $latestTask = Task::where('project_id', $project->id)
                ->latest('id')
                ->first();
    
            $nextNumber = $latestTask ? ((int) \Illuminate\Support\Str::after($latestTask->task_no, '-') + 1) : 1;
            $this->task->task_no = "{$initials}-{$nextNumber}";
        }
    }

    public function save()
    {
    
        $this->validate();

        $storedDocuments = $this->files ? $this->processFiles($this->files) : [];

        $this->files = $storedDocuments;  

        $this->task['start_date'] = $this->task['start_date'] != null ?   $this->convertNepaliToEnglish($this->task['start_date']) : null;
        $this->task['end_date'] = $this->task['end_date'] != null ? $this->convertNepaliToEnglish($this->task['end_date']) : null;

        $dto = TaskAdminDto::fromLiveWireModel($this->task);
        $service = new TaskAdminService();
        $attachmentService = new AttachmentAdminService();
        $activityService = new ActivityAdminService();

        DB::beginTransaction();
        try{
            switch ($this->action){
                case Action::CREATE:
                    $task = $service->store($dto);
                    $activityDto = ActivityAdminDto::fromLiveWireModel(
                        task: $task,
                        action: 'task-created',
                        model: auth()->user()::class,
                        description: "Task created by " . auth()->user()->name
                    );
                    $activityService->store($activityDto);
                    $attachmentService->store(AttachmentAdminDto::fromLiveWireModel(
                        task: $task,
                        model: Task::class,
                        files: $this->files
                    ));
                    DB::commit();
                    $this->successFlash( __('tasktracking::tasktracking.task_created_successfully'));
                    return redirect()->route('admin.tasks.index');
                    break;
                case Action::UPDATE:
                    $task = $service->update($this->task, $dto);

                    $activityDto = ActivityAdminDto::fromLiveWireModel(
                        task: $task,
                        action: 'task-updated',
                        model: auth()->user()::class,
                        description: "Task updated by " . auth()->user()->name
                    );
                
                    $activityService->store($activityDto);
                    DB::commit();
                    $this->successFlash(__('tasktracking::tasktracking.task_updated_successfully'));
                    return redirect()->route('admin.tasks.index');
                    break;
                default:
                    return redirect()->route('admin.tasks.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('tasktracking::tasktracking.an_error_occurred_during_operation_please_try_again_later'));
        }
    }


    private function processFiles(array|string $files): array
    {
        $storedFiles = [];
        foreach ($files as $file) {
            if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
            $storedFiles[] = $this->storeFile($file);
        }
        return $storedFiles;
    }

    private function storeFile($file): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
            return ImageServiceFacade::compressAndStoreImage($file,  config('src.TaskTracking.TaskTracking.path'));
        }

        return FileFacade::saveFile(
            path: config('src.TaskTracking.TaskTracking.path'),
            filename: null,
            file: $file
        );
    }
}
