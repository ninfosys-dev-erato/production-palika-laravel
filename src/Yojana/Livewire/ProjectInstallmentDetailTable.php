<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectInstallmentDetailsExport;
use Src\Yojana\Models\ProjectInstallmentDetail;
use Src\Yojana\Service\ProjectInstallmentDetailAdminService;

class ProjectInstallmentDetailTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectInstallmentDetail::class;
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
        return ProjectInstallmentDetail::query()
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
Column::make("Installment Type", "installment_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Date", "date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Amount", "amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Construction Material Quantity", "construction_material_quantity") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Remarks", "remarks") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan delete')) {
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
        if(!can('plan edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_installment_details.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectInstallmentDetailAdminService();
        $service->delete(ProjectInstallmentDetail::findOrFail($id));
        $this->successFlash("Project Installment Detail Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('plan delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectInstallmentDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectInstallmentDetailsExport($records), 'project_installment_details.xlsx');
    }
}
