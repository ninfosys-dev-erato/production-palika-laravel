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
use Src\Ebps\Exports\BuildingCriteriasExport;
use Src\Ebps\Models\BuildingCriteria;
use Src\Ebps\Service\BuildingCriteriaAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class BuildingCriteriaTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = BuildingCriteria::class;
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
        return BuildingCriteria::query()
        ->select('is_active')
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
            Column::make("Min Gcr", "min_gcr") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Min Far", "min_far") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Min Dist Center", "min_dist_center") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Min Dist Side", "min_dist_side") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Min Dist Right", "min_dist_right") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Setback", "setback") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Dist Between Wall And Boundaries", "dist_between_wall_and_boundaries") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Public Place Distance", "public_place_distance") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Cantilever Distance", "cantilever_distance") ->sortable()->searchable()->collapseOnTablet(),
Column::make("High Tension Distance", "high_tension_distance") ->sortable()->searchable()->collapseOnTablet(),
// Column::make("Is Active", "is_active") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('ebps::ebps.is_active'), 'is_active')
                ->format(function ($value, $row) {
                    $is_active = $row->is_active == 1;
                    return view('livewire-tables.includes.columns.status_switch', [
                        'rowId' => $row->id,
                        'isActive' => $is_active
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
     ];
        if (can('ebps_settings edit') || can('ebps_settings delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('ebps_settings delete')) {
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
        if(!can('ebps_settings edit')){
               SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
               return false;
        }

        $this->dispatch('edit-Building-Criteria', $id);
        // return redirect()->route('admin.ebps.building_criterias.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('ebps_settings delete')){
                SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new BuildingCriteriaAdminService();
        $service->delete(BuildingCriteria::findOrFail($id));
        $this->successFlash(__('ebps::ebps.building_criteria_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_settings delete')){
                    SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new BuildingCriteriaAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BuildingCriteriasExport($records), 'building_criterias.xlsx');
    }

    public function toggleStatus($id)
    {
        $buildingCriteria = BuildingCriteria::findOrFail($id);
        $service = new BuildingCriteriaAdminService();
        $service->toggleStatus($buildingCriteria);
    }
}
