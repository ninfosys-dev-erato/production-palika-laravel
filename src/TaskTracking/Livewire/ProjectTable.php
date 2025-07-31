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
use Src\TaskTracking\Exports\ProjectsExport;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Service\ProjectAdminService;

class ProjectTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Project::class;
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
        return Project::query()
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
            Column::make(__('tasktracking::tasktracking.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.description'), "description") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_edit') || can('project_delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_delete')) {
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
        if(!can('project_edit')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.task.projects.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new ProjectAdminService();
        $service->delete(Project::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.project_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('project_delete')){
                    $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new ProjectAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectsExport($records), 'projects.xlsx');
    }
}
