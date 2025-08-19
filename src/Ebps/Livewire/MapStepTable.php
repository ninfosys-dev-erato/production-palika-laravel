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
use Src\Ebps\Enums\FormPositionEnum;
use Src\Ebps\Enums\FormSubmitterEnum;
use Src\Ebps\Exports\MapStepsExport;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\MapStepAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class MapStepTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = MapStep::class;
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
        return MapStep::query()
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
            Column::make(__('ebps::ebps.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.form_submitter'), "form_submitter") 
                ->format(fn($value) => FormSubmitterEnum::tryFrom($value)?->label() ?? $value)
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.form_position'), "form_position")
                ->format(fn($value) => FormPositionEnum::tryFrom($value)?->label() ?? $value)
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];
        if (can('ebps_settings edit') || can('ebps_settings delete')) {
            $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                    
                    // Add manage roles button
                    $manageRoles = '<a href="' . route('admin.ebps.map_steps.manage-roles', ['id' => $row->id]) . '" class="btn btn-info btn-sm"><i class="bx bx-user-check"></i></a>&nbsp;';
                    $buttons .= $manageRoles;
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
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.ebps.map_steps.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('ebps_settings delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new MapStepAdminService();
        $service->delete(MapStep::findOrFail($id));
        $this->successFlash(__('ebps::ebps.map_step_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_settings delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new MapStepAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MapStepsExport($records), 'map_steps.xlsx');
    }
}
