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
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\AdvancePaymentAdminService;

class AdvancePaymentTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = AdvancePayment::class;
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
        return AdvancePayment::query()
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
            Column::make(__('yojana::yojana.advance_deposit_number'), "advance_deposit_number")->sortable()->searchable()->collapseOnTablet()
            ->format( fn ($value) => replaceNumbersWithLocale($value, true)),
            Column::make(__('yojana::yojana.paid_amount'), "paid_amount")->sortable()->searchable()->collapseOnTablet()
            ->format( fn ($value) => __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($value ?? 0), true)),
        ];
        if (can('advance_payments edit') || can('advance_payments delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';


                if (can('advance_payments edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('advance_payments edit')) {
                    $edit = '<button class="btn btn-info btn-sm" wire:click="printLetter(' . $row->id . ')" ><i class="bx bx-printer"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('advance_payments delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('advance_payments edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        //        return redirect()->route('admin.advance_payments.edit',['id'=>$id]);
        $this->dispatch('load-advance-payment', $id);
    }
    public function delete($id)
    {
        if (!can('advance_payments delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdvancePaymentAdminService();
        $service->delete(AdvancePayment::findOrFail($id));
        $this->successFlash(__('yojana::yojana.advance_payment_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('advance_payments delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdvancePaymentAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new AdvancePaymentsExport($records), 'advance_payments.xlsx');
    }

    public function printLetter($id)
    {
//        dd($this->plan->total_advance_paid,$this->plan->implementationAgency->consumerCommittee->name);
        $exists = LetterSample::where('letter_type', LetterTypes::AdvancePayment)
            ->where('implementation_method_id', $this->plan->implementation_method_id)
            ->exists();

        if ($exists == false) {
            $this->errorFlash(__('Letter Sample Not Found'));
            return false;
        }

        $service = new AdvancePaymentAdminService();
//        $advancePayment = AdvancePayment::find($id);

//        $workOrder =  $service->getWorkOrder($advancePayment->plan->load('costEstimation','agreement','StartFiscalYear','implementationAgency.consumerCommittee', 'implementationAgency.application','implementationAgency.organization'), $advancePayment);

        $workOrder = $service->getWorkOrder($id);
        if ($workOrder?->id) {
            $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
            $this->dispatch('open-pdf-in-new-tab', url: $url);
        } else {
            $this->errorFlash(__('Letter Sample Not Found'));
        }
    }
}
