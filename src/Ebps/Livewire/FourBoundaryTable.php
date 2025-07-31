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
use Src\Ebps\Exports\FourBoundariesExport;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Service\FourBoundaryAdminService;

class FourBoundaryTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = FourBoundary::class;
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
        return FourBoundary::query()
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
            Column::make(__('ebps::ebps.land_detail_id'), "land_detail_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('ebps::ebps.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('ebps::ebps.direction'), "direction") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('ebps::ebps.distance'), "distance") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('ebps::ebps.lot_no'), "lot_no") ->sortable()->searchable()->collapseOnTablet(),
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
        return redirect()->route('admin.four_boundaries.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('ebps_settings delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new FourBoundaryAdminService();
        $service->delete(FourBoundary::findOrFail($id));
        $this->successFlash(__('ebps::ebps.four_boundary_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_settings delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new FourBoundaryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FourBoundariesExport($records), 'four_boundaries.xlsx');
    }
}
