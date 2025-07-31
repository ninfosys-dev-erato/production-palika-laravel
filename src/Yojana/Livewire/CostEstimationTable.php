<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\PlansExport;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Service\PlanAdminService;

class CostEstimationTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = CostEstimation::class;
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
        return CostEstimation::where('deleted_at',null)
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
            Column::make(__('yojana::yojana.date'), "date") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.total_cost'), "total_cost") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.status'), "status") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.is_revised'), "is_revised") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.revision_count'), "revision_no") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.is_document_uploaded'), "document_upload") ->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('costEstimation edit') || can('costEstimation delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('costEstimation show')) {
                    $show = '<button class="btn btn-secondary btn-sm" wire:click="show(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $show;
                }
                if (can('costEstimation edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('costEstimation delete')) {
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
        if(!can('costEstimation edit')){
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.costEstimation.edit',['id'=>$id]);
    }
    public function show($id)
    {
        if(!can('costEstimation show')){
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.costEstimation.show',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('costEstimation delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAdminService();
        $service->delete(CostEstimation::findOrFail($id));
        $this->successFlash(__('yojana::yojana.cost_estimation_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('costEstimation delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PlansExport($records), 'costEstimation.xlsx');
    }
}
