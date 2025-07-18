<?php

namespace Src\TaskTracking\Livewire;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\TaskTracking\DTO\ActivityAdminDto;
use Src\TaskTracking\DTO\AttachmentAdminDto;
use Src\TaskTracking\DTO\CommentAdminDto;
use Src\TaskTracking\Models\Comment;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Service\ActivityAdminService;
use Src\TaskTracking\Service\AttachmentAdminService;
use Src\TaskTracking\Service\CommentAdminService;

class TaskCommentActivity extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Task $task;
    public string $commentContent = ''; // Bind textarea content
    public $uploadFiles = '';

    protected function rules(): array
    {
        return [
            'commentContent' => 'nullable|string|max:1000', // Validate comment content
            'uploadFiles' => 'nullable', // Validate comment content
        ];
    }
    public function render(){
        return view("TaskTracking::livewire.task.comment");
    }

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function addComment()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $storedFiles = $this->uploadFiles ? $this->processFiles($this->uploadFiles) : [];

            $commentDto = CommentAdminDto::fromLiveWireModel(
                task: $this->task,
                model: auth()->user()::class,
                files: $this->commentContent
            );
            $commentService = new CommentAdminService();
            $comment = $commentService->store($commentDto);

            $this->logActivity('comment-added', "Comment added by " . auth()->user()->name);

            if (!empty($storedFiles)) {
                $this->storeAttachments($comment, $storedFiles);
                $this->logActivity('attachment-uploaded', "Attachment added by " . auth()->user()->name);
            }

            DB::commit();
            $this->successFlash(__('tasktracking::tasktracking.comment_added_successfully'));
            $this->resetForm();
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('tasktracking::tasktracking.an_error_occurred_please_try_again'));
        }
    }

    private function processFiles(array|string $files): array
    {
        $storedFiles = [];
        foreach ($files as $file) {
            $storedFiles[] = $this->storeFile($file);
        }
        return $storedFiles;
    }

    private function storeFile($file): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
            return ImageServiceFacade::compressAndStoreImage($file, config('src.TaskTracking.TaskTracking.path'));
        }

        return FileFacade::saveFile(
            path: config('src.TaskTracking.TaskTracking.path'),
            filename: null,
            file: $file
        );
    }

    private function storeAttachments(Comment $comment, array $storedFiles)
    {
        $attachmentService = new AttachmentAdminService();
        $attachmentDto = AttachmentAdminDto::fromLiveWireModel(
            task: $comment,
            model: Comment::class,
            files: $storedFiles
        );
        $attachmentService->store($attachmentDto);
    }

    private function logActivity(string $action, string $description)
    {
        $activityService = new ActivityAdminService();
        $activityDto = ActivityAdminDto::fromLiveWireModel(
            task: $this->task,
            action: $action,
            model: auth()->user()::class,
            description: $description
        );
        $activityService->store($activityDto);
    }

    private function resetForm()
    {
        $this->commentContent = '';
        $this->uploadFiles = '';
        $this->dispatch('comment-added');
    }

}
