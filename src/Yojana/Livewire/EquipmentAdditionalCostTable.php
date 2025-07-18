<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\EquipmentAdditionalCostsExport;
use Src\Yojana\Models\EquipmentAdditionalCost;
use Src\Yojana\Service\EquipmentAdditionalCostAdminService;

class EquipmentAdditionalCostTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = EquipmentAdditionalCost::class;
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
        return EquipmentAdditionalCost::query()
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
            Column::make("Equipment Id", "equipment_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Fiscal Year Id", "fiscal_year_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Unit Id", "unit_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Rate", "rate") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('equipment_additional_costs edit') || can('equipment_additional_costs delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('equipment_additional_costs edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('equipment_additional_costs delete')) {
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
        if(!can('equipment_additional_costs edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.equipment_additional_costs.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('equipment_additional_costs delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new EquipmentAdditionalCostAdminService();
        $service->delete(EquipmentAdditionalCost::findOrFail($id));
        $this->successFlash("Equipment Additional Cost Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('equipment_additional_costs delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new EquipmentAdditionalCostAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new EquipmentAdditionalCostsExport($records), 'equipment_additional_costs.xlsx');
    }
}
