<?php

namespace Src\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Exports\BuildingRoofTypesExport;
use Src\Ebps\Models\BuildingRoofType;
use Src\Ebps\Service\BuildingRoofTypeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class BuildingRoofTypeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = BuildingRoofType::class;
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
        return BuildingRoofType::query()
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
            Column::make("Title", "title") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('ebps_building_roof_types edit') || can('ebps_building_roof_types delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_building_roof_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('ebps_building_roof_types delete')) {
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
        if(!can('ebps_building_roof_types edit')){
               SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
               return false;
        }
        // return redirect()->route('admin.building_roof_types.edit',['id'=>$id]);
        $this->dispatch('edit-building-roof-type', $id);

    }
    public function delete($id)
    {
        if(!can('ebps_building_roof_types delete')){
                SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new BuildingRoofTypeAdminService();
        $service->delete(BuildingRoofType::findOrFail($id));
        $this->successFlash(__('ebps::ebps.building_roof_type_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_building_roof_types delete')){
                    SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new BuildingRoofTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BuildingRoofTypesExport($records), 'building_roof_types.xlsx');
    }
}
