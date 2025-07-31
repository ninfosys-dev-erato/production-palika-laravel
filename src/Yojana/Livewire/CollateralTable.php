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
use Src\Yojana\Models\Collateral;
use Src\Yojana\Service\CollateralAdminService;

class CollateralTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Collateral::class;
    public $plan;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function mount($plan)
    {
        $this->plan = $plan;
    }
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
        return Collateral::query()
            ->where('plan_id', $this->plan->id)
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
Column::make(__("yojana::yojana.party_type"), "party_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.party"), "party_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.deposit_type"), "deposit_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.deposit_number"), "deposit_number") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.contract_number"), "contract_number") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.bank"), "bank") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.issue_date"), "issue_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.validity_period"), "validity_period") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__("yojana::yojana.amount"), "amount") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('collaterals edit') || can('collaterals delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('collaterals edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('collaterals delete')) {
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
        if(!can('collaterals edit')){
               SessionFlash::WARNING_FLASH(__('You Cannot Perform this action'));
               return false;
        }
        $this->dispatch('edit-collateral', $id);
    }
    public function delete($id)
    {
        if(!can('collaterals delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new CollateralAdminService();
        $service->delete(Collateral::findOrFail($id));
        $this->successFlash(__("Collateral Deleted Successfully"));
    }
    public function deleteSelected(){
        if(!can('collaterals delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new CollateralAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'collaterals.xlsx');
    }
}
