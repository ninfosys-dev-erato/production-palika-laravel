<?php

namespace Src\TaskTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\TaskTracking\DTO\ActivityAdminDto;
use Src\TaskTracking\Enums\TaskStatus;
use Src\TaskTracking\Exports\TasksExport;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Models\TaskType;
use Src\TaskTracking\Service\ActivityAdminService;
use Src\TaskTracking\Service\TaskAdminService;

class TaskTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Task::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setAdditionalSelects(['tms_tasks.id as task_id'])
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return Task::query()
            ->select('tms_tasks.*')
            ->with(['project', 'taskType', 'assignee', 'reporter'])
            ->where('tms_tasks.deleted_at', null)
            ->where('tms_tasks.deleted_by', null)
            ->orderBy('tms_tasks.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [
            SelectFilter::make(__('tasktracking::tasktracking.status'))
                ->options([
                    '' => 'All',
                    'todo' => 'To Do',
                    'In progress' => 'In Progress',
                    'completed' => 'Completed'
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status', $value);
                    }
                }),

            SelectFilter::make(__('tasktracking::tasktracking.project'))
                ->options(Project::pluck('title', 'id')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('project_id', $value);
                    }
                }),

            SelectFilter::make(__('tasktracking::tasktracking.task_type'))
                ->options(TaskType::pluck('type_name', 'id')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('task_type_id', $value);
                    }
                }),
        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('tasktracking::tasktracking.status'), 'status')
                ->format(function ($value, $row) {
                    return (string) view('TaskTracking::livewire.table.col-status-dropdown', [
                        'row' => $row,
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),


            Column::make(__('tasktracking::tasktracking.project'), "project.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.task'), "taskType.type_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.number'), "task_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.assignee'))
                ->label(function ($row) {
                    if ($row->assignee) {
                        return $row->assignee->name ?? 'N/A';
                    }
                    return 'Unassigned';
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.reporter'))
                ->label(function ($row) {
                    if ($row->reporter) {
                        return $row->reporter->name ?? 'N/A';
                    }
                    return 'Unassigned';
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.start_date'))
                ->label(function ($row) {
                    return replaceNumbers($row->start_date, true);
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('tasktracking::tasktracking.end_date'))
                ->label(function ($row) {
                    return replaceNumbers($row->end_date, true);
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];
        if (can('task_update') || can('task_delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->task_id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                $buttons .= $view;

                if (can('task_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->task_id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('task_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('task_update')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.tasks.edit', ['id' => $id]);
    }
    public function view($id)
    {
        if (!can('task_view')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.tasks.view', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('task_delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new TaskAdminService();
        $service->delete(Task::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.task_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('task_delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new TaskAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TasksExport($records), 'tasks.xlsx');
    }

    public function updateStatus(Task $task, TaskStatus $newStatus)
    {
        $service = new TaskAdminService();
        $activityService = new ActivityAdminService();
        $task = $service->updateStatus($task, $newStatus);
        $activityDto = ActivityAdminDto::fromLiveWireModel(
            task: $task,
            action: 'task-created',
            model: auth()->user()::class,
            description: "Task created by " . auth()->user()->name
        );
        $activityService->store($activityDto);
        $this->successFlash(__('tasktracking::tasktracking.task_status_updated_successfully'));
    }
}
