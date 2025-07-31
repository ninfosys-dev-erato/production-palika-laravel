<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectDeadlineExtensionsExport;
use Src\Yojana\Models\ProjectDeadlineExtension;
use Src\Yojana\Service\ProjectDeadlineExtensionAdminService;

class ProjectDeadlineExtensionTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectDeadlineExtension::class;
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
        return ProjectDeadlineExtension::query()
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
            Column::make("Project Id", "project_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Extended Date", "extended_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("En Extended Date", "en_extended_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Submitted Date", "submitted_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("En Submitted Date", "en_submitted_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Remarks", "remarks") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_deadline_extensions edit') || can('project_deadline_extensions delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('project_deadline_extensions edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_deadline_extensions delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
                    $buttons .= $delete;
                }
                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('project_deadline_extensions edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_deadline_extensions.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_deadline_extensions delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectDeadlineExtensionAdminService();
        $service->delete(ProjectDeadlineExtension::findOrFail($id));
        $this->successFlash("Project Deadline Extension Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('project_deadline_extensions delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectDeadlineExtensionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectDeadlineExtensionsExport($records), 'project_deadline_extensions.xlsx');
    }
}
