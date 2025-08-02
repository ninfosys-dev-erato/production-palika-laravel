<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Exports\AdvancePaymentsExport;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\Payment;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\AdvancePaymentAdminService;
use Src\Yojana\Service\PaymentAdminService;
use Src\Yojana\Service\WorkOrderAdminService;

class PaymentTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Payment::class;
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
        return Payment::query()
            ->select('*')
            ->where('plan_id', $this->plan->id)
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
            // Column::make(__('yojana::yojana.installment'), "installment")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.installment'))
                ->label(function ($row) {
                    return $row->installment?->label();
                })->html()
                ->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.date'), "date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.clearance_date'), "clearance_date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.advance_deposit_number'), "advance_deposit_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.paid_amount'), "paid_amount")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';


                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan edit')) {
                    $edit = '<button class="btn btn-info btn-sm" wire:click="printLetter(' . $row->id . ')" ><i class="bx bx-printer"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function delete($id)
    {
        if(!can('plan delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PaymentAdminService();
        $service->delete(Payment::findOrFail($id));
        $this->successFlash(__('yojana::yojana.payment_deleted_successfully'));
    }

    public function edit($id)
    {
        if(!can('plan edit')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-payment',$id);
    }

    public function printWorkOrder($id)
    {
        $payment = Payment::find($id);
        $plan = $payment->plan;
        $service = new WorkOrderAdminService();
        $workOrder = $service->workOrderLetter(LetterTypes::Payment, $plan);
        if (!isset($workOrder)){
            $this->errorFlash('Template Not Found');
            return false;
        }
        $url = route('admin.plans.work_orders.preview',['id'=>$workOrder->id]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

}
