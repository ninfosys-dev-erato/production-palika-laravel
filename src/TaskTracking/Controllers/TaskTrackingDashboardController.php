<?php

namespace Src\TaskTracking\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\View\View;
use Src\TaskTracking\Enums\TaskStatus;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Models\TaskType;

class TaskTrackingDashboardController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [];
    }

    public function index(): View
    {
        try {
            [
                $totalTaskCount,
                $taskTodoCount,
                $taskInProgressCount,
                $taskCompletedCount,
                $totalProjectCount,
                $totalTaskType,
                $projectChart
            ] = Cache::remember('task_dashboard_data', now()->addMinutes(5), function () {
                // Execute queries sequentially instead of using Concurrency::run()
                $totalTask = Task::whereNull('deleted_at')->count() ?? 0;
                $totalTodoTask = Task::where('status', TaskStatus::TODO)->count() ?? 0;
                $totalInProgressTask = Task::where('status', TaskStatus::INPROGRESS)->count() ?? 0;
                $totalCompletedTask = Task::where('status', TaskStatus::COMPLETED)->count() ?? 0;
                $totalProjectCount = Project::whereNull('deleted_at')->count() ?? 0;
                $totalTaskType = TaskType::whereNull('deleted_at')->count() ?? 0;
                $projectChart = Project::withCount('tasks')
                    ->whereNull('deleted_at')
                    ->get()
                    ->mapWithKeys(function ($project) {
                        $projectTitle = trim($project->title) ?: 'Unnamed Project';

                        return [$projectTitle => $project->tasks_count];
                    });

                return [$totalTask, $totalTodoTask, $totalInProgressTask, $totalCompletedTask, $totalProjectCount, $totalTaskType, $projectChart];
            });

        } catch (\Exception $e) {
            Cache::forget('task_dashboard_data');

            return redirect()->route('admin.task-tracking.index');
        }

        return view('TaskTracking::dashboard', [
            'totalTaskCount' => $totalTaskCount,
            'taskTodoCount' => $taskTodoCount,
            'taskInProgressCount' => $taskInProgressCount,
            'taskCompletedCount' => $taskCompletedCount,
            'totalProjectCount' => $totalProjectCount,
            'totalTaskType' => $totalTaskType,
            'projectChart' => $projectChart,
        ]);

    }
}
