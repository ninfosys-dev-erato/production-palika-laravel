<?php

namespace Src\Yojana\Livewire;


use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\WorkOrdersExport;
use Src\Yojana\Models\WorkOrder;
use Src\Yojana\Service\WorkOrderAdminService;

class WorkOrderTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = WorkOrder::class;
    public $planId;
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
    public function mount($planId = null)
    {
        $this->planId = $planId;
    }

    public function builder(): Builder
    {
        return WorkOrder::query()
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->when($this->planId, function ($query) {
                $query->where('plan_id', $this->planId);
            })
            ->orderBy('created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.date'), 'date')
                ->format(function ($value) {
                    try {
                        return $value ? replaceNumbers($this->adToBs($value),true ): '-';
                    } catch (\Exception $e) {
                        return '-';
                    }
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            // Column::make(__('yojana::yojana.plan_id'), "plan_id")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.plan_name'), "plan_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.subject'), "subject")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.letter_body'), "letter_body")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('work_orders edit') || can('work_orders delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';
                if (can('work_orders print')) {
                    $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('work_orders edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('workOrder-edit', $id);
        // return redirect()->route('admin.work_orders.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('work_orders delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WorkOrderAdminService();
        $service->delete(WorkOrder::findOrFail($id));
        $this->successFlash(__('yojana::yojana.work_order_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('work_orders delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WorkOrderAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new WorkOrdersExport($records), 'work_orders.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.plans.work_orders.preview', ['id' => $id]);
    }
}
