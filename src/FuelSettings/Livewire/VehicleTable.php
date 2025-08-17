<?php

namespace Src\FuelSettings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\FuelSettings\Exports\VehiclesExport;
use Src\FuelSettings\Models\Vehicle;
use Src\FuelSettings\Service\VehicleAdminService;

class VehicleTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Vehicle::class;
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
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return Vehicle::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->with(['employee', 'vehicleCategory'])
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make("Employee Id", "employee_id")
                ->format(fn($value, $row) => $row->employee?->name ?? 'N/A')
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make("Vehicle Category Id", "vehicle_category_id")
                ->format(fn($value, $row) => $row->vehicleCategory?->title_en ?? 'N/A')
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make("Vehicle Number", "vehicle_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Chassis Number", "chassis_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Engine Number", "engine_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Fuel Type", "fuel_type")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Driver Name", "driver_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make("License Number", "license_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make("License Photo", "license_photo")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Signature", "signature")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Driver Contact No", "driver_contact_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Vehicle Detail", "vehicle_detail")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('fms_vehicles edit') || can('fms_vehicles delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('fms_vehicles edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('fms_vehicles delete')) {
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
        if (!can('fms_vehicles edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.vehicles.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('fms_vehicles delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VehicleAdminService();
        $service->delete(Vehicle::findOrFail($id));
        $this->successFlash("Vehicle Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('fms_vehicles delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VehicleAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new VehiclesExport($records), 'vehicles.xlsx');
    }
}
