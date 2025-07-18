<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\BudgetHeadsExport;
use Src\Yojana\Models\BudgetHead;
use Src\Yojana\Service\BudgetHeadAdminService;

class BudgetHeadTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = BudgetHead::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
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
        return BudgetHead::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),

        ];
        if (can('budget_heads edit') || can('budget_heads delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('budget_heads edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('budget_heads delete')) {
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
        if (!can('budget_heads edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
//        return redirect()->route('admin.budget_heads.edit', ['id' => $id]);
        $this->dispatch('edit-budget-head', $id);
    }
    public function delete($id)
    {
        if (!can('budget_heads delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BudgetHeadAdminService();
        $service->delete(BudgetHead::findOrFail($id));
        $this->successToast(__('yojana::yojana.budget_head_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('budget_heads delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BudgetHeadAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BudgetHeadsExport($records), 'budget_heads.xlsx');
    }
}
