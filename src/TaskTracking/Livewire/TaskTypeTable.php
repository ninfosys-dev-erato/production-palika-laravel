<?php

namespace Src\TaskTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\TaskTracking\Exports\TaskTypesExport;
use Src\TaskTracking\Models\TaskType;
use Src\TaskTracking\Service\TaskTypeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class TaskTypeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = TaskType::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100,500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return TaskType::query()
            ->where('deleted_at',null)
            ->where('deleted_by',null)
           ->orderBy('created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__('tasktracking::tasktracking.type_name'), "type_name") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('task_type_update') || can('task_type_delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('task_type_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('task_type_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('task_type_udpate')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.task-types.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('task_type_delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new TaskTypeAdminService();
        $service->delete(TaskType::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.task_type_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('task_type_delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new TaskTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TaskTypesExport($records), 'task_types.xlsx');
    }
}
