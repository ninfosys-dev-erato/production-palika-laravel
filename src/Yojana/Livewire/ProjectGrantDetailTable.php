<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectGrantDetailsExport;
use Src\Yojana\Models\ProjectGrantDetail;
use Src\Yojana\Service\ProjectGrantDetailAdminService;

class ProjectGrantDetailTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectGrantDetail::class;
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
        return ProjectGrantDetail::query()
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
Column::make("Grant Source", "grant_source") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Asset Name", "asset_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Quantity", "quantity") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Asset Unit", "asset_unit") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_grant_details edit') || can('project_grant_details delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_grant_details edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_grant_details delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
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
        if(!can('project_grant_details edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_grant_details.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_grant_details delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectGrantDetailAdminService();
        $service->delete(ProjectGrantDetail::findOrFail($id));
        $this->successFlash("Project Grant Detail Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('project_grant_details delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectGrantDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectGrantDetailsExport($records), 'project_grant_details.xlsx');
    }
}
