<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\TechnicalCostEstimatesExport;
use Src\Yojana\Models\TechnicalCostEstimate;
use Src\Yojana\Service\TechnicalCostEstimateAdminService;

class TechnicalCostEstimateTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = TechnicalCostEstimate::class;
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
        return TechnicalCostEstimate::query()
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
            Column::make("Project Id", "project_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Detail", "detail") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Quantity", "quantity") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Unit Id", "unit_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Rate", "rate") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('technical_cost_estimates edit') || can('technical_cost_estimates delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('technical_cost_estimates edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('technical_cost_estimates delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
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
        if(!can('technical_cost_estimates edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.technical_cost_estimates.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('technical_cost_estimates delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new TechnicalCostEstimateAdminService();
        $service->delete(TechnicalCostEstimate::findOrFail($id));
        $this->successFlash("Technical Cost Estimate Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('technical_cost_estimates delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new TechnicalCostEstimateAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TechnicalCostEstimatesExport($records), 'technical_cost_estimates.xlsx');
    }
}
