<?php

namespace Src\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Config;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Exports\MapAppliesExport;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Service\MapApplyAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class OldMapApplicationTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = MapApply::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('ebps_map_applies.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['ebps_map_applies.id'])
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
        return MapApply::query()
        ->with(['fiscalYear', 'customer', 'landDetail', 'constructionType', 'mapApplySteps', 'houseOwner', 'localBody', 'district'])
        ->select('full_name', 'mobile_no', 'province_id', 'local_body_id', 'district_id', 'ward_no')
            ->where('ebps_map_applies.deleted_at',null)
            ->where('application_type', ApplicationTypeEnum::OLD_APPLICATIONS)
            ->where('ebps_map_applies.deleted_by',null)
           ->orderBy('ebps_map_applies.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [

            Column::make(__('ebps::ebps.submission_no'), "submission_id") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.fiscal_year'), "fiscalYear.year") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.construction_type'), "constructionType.title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.usage'), "usage")
            ->format(fn($value) => Config::get('src.Ebps.usage')[$value] ?? $value)
            ->sortable()
            ->searchable()
            ->collapseOnTablet(),
            Column::make(__('ebps::ebps.house_owner'))->label(
                fn($row, Column $column) => view('Ebps::livewire.table.col-house-owner-detail', [
                    'row' => $row,
                ])->render()
            )->html(),
                    
           
            Column::make(__('ebps::ebps.applied_date'), "applied_date") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('ebps_map_applies edit') || can('ebps_map_applies delete')) {
            $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_map_applies access')) {
                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('ebps_map_applies edit')) {
                    $edit = '<button type="button" class="btn btn-primary btn-sm"  wire:click="edit(' . $row->id . ')"><i class="bx bx-edit"></i></button>';
                    $buttons .= $edit;
                }

                if (can('ebps_map_applies delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm"  wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
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
        return redirect()->route('admin.ebps.old_applications.edit',['id'=>$id]);
    }
    public function chooseOrganization($id)
    {
        $this->dispatch('open-choose-organization-modal', id: $id);
    }

    public function view($id)
    {
        if(!can('ebps_map_applies access')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.ebps.old_applications.view',['id'=>$id]);
    }

//    public function moveFurther($id)
//    {
//        return redirect()->route('admin.ebps.map_applies.step', ['id'=>$id]);
//    }


    public function delete($id)
    {
        if(!can('ebps_map_applies delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new MapApplyAdminService();
        $service->delete(MapApply::findOrFail($id));
        $this->successFlash(__('ebps::ebps.map_apply_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_map_applies delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new MapApplyAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MapAppliesExport($records), 'map_applies.xlsx');
    }
}
