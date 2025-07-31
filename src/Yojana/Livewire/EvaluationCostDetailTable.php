<?php

namespace Src\Yojana\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Yojana\Exports\YojanaExport;
use Src\Yojana\Models\EvaluationCostDetail;
use Src\Yojana\Service\EvaluationCostDetailAdminService;

class EvaluationCostDetailTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = EvaluationCostDetail::class;
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
        return EvaluationCostDetail::query()
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
            Column::make(__('yojana::yojana.evaluationcostdetailevaluation_id'), "evaluation_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailactivity_id'), "activity_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailunit'), "unit") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailagreement'), "agreement") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailbefore_this'), "before_this") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailup_to_date_amount'), "up_to_date_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailcurrent'), "current") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailrate'), "rate") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailassessment_amount'), "assessment_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.evaluationcostdetailvat_amount'), "vat_amount") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('evaluation_cost_details edit') || can('evaluation_cost_details delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('evaluation_cost_details edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('evaluation_cost_details delete')) {
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
        if(!can('evaluation_cost_details edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.evaluation_cost_details.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('evaluation_cost_details delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new EvaluationCostDetailAdminService();
        $service->delete(EvaluationCostDetail::findOrFail($id));
        $this->successFlash(__('yojana::yojana.evaluation_cost_detail_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('evaluation_cost_details delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new EvaluationCostDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'evaluation-cost-details.xlsx');
    }
}
