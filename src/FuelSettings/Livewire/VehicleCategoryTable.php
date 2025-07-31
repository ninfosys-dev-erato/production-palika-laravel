<?php

namespace Src\FuelSettings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\FuelSettings\Models\VehicleCategory;
use Src\FuelSettings\Exports\VehicleCategoriesExport;
use Src\FuelSettings\Service\VehicleCategoryAdminService;

class VehicleCategoryTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = VehicleCategory::class;
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
        return VehicleCategory::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make("Title", "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Title En", "title_en")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('vehicle_categories edit') || can('vehicle_categories delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('vehicle_categories edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('vehicle_categories delete')) {
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
        if (!can('vehicle_categories edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $this->dispatch('edit-vehicle-category',vehicleCategory : $id);
//        return redirect()->route('admin.vehicle_categories.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('vehicle_categories delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VehicleCategoryAdminService();
        $service->delete(VehicleCategory::findOrFail($id));
        $this->successFlash("Vehicle Category Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('vehicle_categories delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VehicleCategoryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new VehicleCategoriesExport($records), 'vehicle_categories.xlsx');
    }
}
