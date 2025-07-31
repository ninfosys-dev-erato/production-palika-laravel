<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectMaintenanceArrangementsExport;
use Src\Yojana\Models\ProjectMaintenanceArrangement;
use Src\Yojana\Service\ProjectMaintenanceArrangementAdminService;

class ProjectMaintenanceArrangementTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectMaintenanceArrangement::class;
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
        return ProjectMaintenanceArrangement::query()
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
Column::make("Office Name", "office_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Public Service", "public_service") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Service Fee", "service_fee") ->sortable()->searchable()->collapseOnTablet(),
Column::make("From Fee Donation", "from_fee_donation") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Others", "others") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_maintenance_arrangements edit') || can('project_maintenance_arrangements delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_maintenance_arrangements edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_maintenance_arrangements delete')) {
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
        if(!can('project_maintenance_arrangements edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_maintenance_arrangements.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_maintenance_arrangements delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectMaintenanceArrangementAdminService();
        $service->delete(ProjectMaintenanceArrangement::findOrFail($id));
        $this->successFlash("Project Maintenance Arrangement Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('project_maintenance_arrangements delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectMaintenanceArrangementAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectMaintenanceArrangementsExport($records), 'project_maintenance_arrangements.xlsx');
    }
}
