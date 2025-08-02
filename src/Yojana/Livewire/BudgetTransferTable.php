<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\DTO\BudgetTransferDetailAdminDto;
use Src\Yojana\Exports\BudgetSourcesExport;
use Src\Yojana\Exports\BudgetTransferExport;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\BudgetTransfer;
use Src\Yojana\Models\BudgetTransferDetails;
use Src\Yojana\Service\BudgetSourceAdminService;
use Src\Yojana\Service\BudgetTransferAdminService;
use Src\Yojana\Service\BudgetTransferDetailAdminService;
use App\Traits\HelperDate;

class BudgetTransferTable extends DataTableComponent
{

    use SessionFlash, IsSearchable, HelperDate;
    protected $model = BudgetTransfer::class;
    public $plan;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_budget_transfer.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_budget_transfer.id'])
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
        if ($this->plan){
           return BudgetTransfer::query()
                ->Where('from_plan', $this->plan->id)
               ->orWhere('to_plan', $this->plan->id)
                ->where('pln_budget_transfer.deleted_at', null)
                ->where('pln_budget_transfer.deleted_by', null)
                ->orderBy('pln_budget_transfer.created_at', 'DESC');
        }

        return BudgetTransfer::query()
            ->where('pln_budget_transfer.deleted_at', null)
            ->where('pln_budget_transfer.deleted_by', null)
            ->orderBy('pln_budget_transfer.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $locale = app()->getLocale();
        $columns = [
            Column::make(__('yojana::yojana.transferred_from'), "fromPlan.project_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.transferred_to'), "toPlan.project_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.amount'), "amount")->sortable()->searchable()->collapseOnTablet()
            ->format( fn ($value) => __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($value??0), true) ),
            Column::make(__('yojana::yojana.date'), "date")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) use ($locale) {
                    if ($locale == 'en') {
                        return \Carbon\Carbon::parse($value)->format('F j, Y, g:i A'); // Example: March 23, 2025, 2:45 PM
                    } else {
                        return replaceNumbers($this->adToBs($value), true);
                    }
                }),

        Column::make(__('yojana::yojana.transferrer'), "user.name")->sortable()->searchable()->collapseOnTablet()
        ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('plan edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
//        $this->dispatch('edit-budget-transfer', budgetTransfer: $id);
         return redirect()->route('admin.budget_transfer.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BudgetTransferAdminService();
        $budgetTransfer = BudgetTransfer::findOrFail($id);
        $details = $budgetTransfer->budgetTransferDetails;
        $service->delete($budgetTransfer);
        $detailService = new BudgetTransferDetailAdminService();
        foreach ($details as $detail) {
            $detailService->delete($detail);
        }
        $this->successFlash(__('yojana::yojana.budget_transfer_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BudgetTransferAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BudgetTransferExport($records), 'budget_transfer.xlsx');
    }
}
