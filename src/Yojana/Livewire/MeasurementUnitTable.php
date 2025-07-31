<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\MeasurementUnitsExport;
use Src\Yojana\Models\MeasurementUnit;
use Src\Yojana\Models\Type;
use Src\Yojana\Service\MeasurementUnitAdminService;

class MeasurementUnitTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = MeasurementUnit::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_measurement_units.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_measurement_units.id'])
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
        return MeasurementUnit::query()
            ->with('type')
            ->where('pln_measurement_units.deleted_at',null)
            ->where('pln_measurement_units.deleted_by',null)
           ->orderBy('pln_measurement_units.created_at','DESC');// Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {

     $columns = [
            Column::make(__('yojana::yojana.measurement_type'), "type.title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('measurement_units edit') || can('measurement_units delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('measurement_units edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('measurement_units delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
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
        if(!can('measurement_units edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
//        return redirect()->route('admin.measurement_units.edit',['id'=>$id]);
        $this->dispatch('edit-measurement-unit',measurementUnit :$id);
    }
    public function delete($id)
    {
        if(!can('measurement_units delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new MeasurementUnitAdminService();
        $service->delete(MeasurementUnit::findOrFail($id));
        $this->successToast(__('yojana::yojana.measurement_unit_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('measurement_units delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new MeasurementUnitAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MeasurementUnitsExport($records), 'measurement_units.xlsx');
    }
}
