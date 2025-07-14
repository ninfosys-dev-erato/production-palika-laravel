<?php

namespace Src\TaskTracking\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Notifications\TaskAssignedNotification;
use Src\TaskTracking\Notifications\TaskReporterNotification;

class SendTaskNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    protected $notifyAssignee;
    protected $notifyReporter;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task, bool $notifyAssignee = false, bool $notifyReporter = false)
    {
        $this->task = $task;
        $this->notifyAssignee = $notifyAssignee;
        $this->notifyReporter = $notifyReporter;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->notifyAssignee && $this->task->assignee) {
            $this->task->assignee->notify(new TaskAssignedNotification($this->task));
        }

        if ($this->notifyReporter && $this->task->reporter) {
            $this->task->reporter->notify(new TaskReporterNotification($this->task));
        }
    }
}
