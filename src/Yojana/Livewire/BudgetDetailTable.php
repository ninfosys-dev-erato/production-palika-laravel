<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\BudgetDetailsExport;
use Src\Yojana\Models\BudgetDetail;
use Src\Yojana\Service\BudgetDetailAdminService;

class BudgetDetailTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = BudgetDetail::class;
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
        return BudgetDetail::query()
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
            Column::make(__('yojana::yojana.ward'), replaceNumbersWithLocale("ward_id", true)) ->sortable()->searchable()->collapseOnTablet()
                ->format(fn ($value) => replaceNumbersWithLocale($value, true)),
            Column::make(__('yojana::yojana.program'), "program")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.amount'), "amount")->sortable()->searchable()->collapseOnTablet()
                ->format(fn ($value) => __('yojana::yojana.rs').replaceNumbersWithLocale($value, true)),
         Column::make(__('yojana::yojana.remaining_amount'))
             ->label(fn($row) => __('yojana::yojana.rs').replaceNumbersWithLocale($row->remaining_amount, true))->sortable()->searchable()->collapseOnTablet()
     ];
        if (can('budget_details edit') || can('budget_details delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('budget_details edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('budget_details delete')) {
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
        if(!can('budget_details edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
//        return redirect()->route('admin.budget_details.edit',['id'=>$id]);
        $this->dispatch('edit-budget-details',$id);

    }
    public function delete($id)
    {
        if(!can('budget_details delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new BudgetDetailAdminService();
        $service->delete(BudgetDetail::findOrFail($id));
        $this->successFlash(__('yojana::yojana.budget_detail_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('budget_details delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new BudgetDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BudgetDetailsExport($records), 'budget_details.xlsx');
    }
}
