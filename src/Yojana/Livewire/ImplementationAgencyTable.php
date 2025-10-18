<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Exports\ImplementationAgenciesExport;
use Src\Yojana\Models\ImplementationAgency;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\ImplementationAgencyAdminService;
use Src\Yojana\Service\WorkOrderAdminService;

class ImplementationAgencyTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ImplementationAgency::class;
    public $planId;
    public $plan;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_implementation_agencies.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_implementation_agencies.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function mount($plan = null)
    {
        $this->plan = $plan;
        $this->planId = $plan->id;
    }
    public function builder(): Builder
    {
        return ImplementationAgency::query()
            ->with(['consumerCommittee', 'implementationMethod', 'organization', 'application'])
            ->whereNull('pln_implementation_agencies.deleted_at')
            ->whereNull('pln_implementation_agencies.deleted_by')
            ->when($this->planId, function ($query) {
                $query->where('plan_id', $this->planId);
            })
            ->orderBy('pln_implementation_agencies.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [];

        $model = $this->plan?->implementationMethod?->model;

        if ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByQuotation) {
            $columns[] = Column::make(__('yojana::yojana.implementation_agency'), "organization.name")
                ->sortable()->searchable()->collapseOnTablet();
        } elseif ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByConsumerCommittee) {
            $columns[] = Column::make(__('yojana::yojana.implementation_agency'), "consumerCommittee.name")
                ->sortable()->searchable()->collapseOnTablet();
        } elseif ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByNGO) {
            $columns[] = Column::make(__('yojana::yojana.implementation_agency'), "organization.name")
                ->sortable()->searchable()->collapseOnTablet();
        } elseif ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract) {
            $columns[] = Column::make(__('yojana::yojana.implementation_agency'), "organization.name")
                ->sortable()->searchable()->collapseOnTablet();
        } elseif ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByTrust) {
            $columns[] = Column::make(__('yojana::yojana.implementation_agency'), "application.applicant_name")
                ->sortable()->searchable()->collapseOnTablet();
        }

        $columns[] = Column::make(__('yojana::yojana.implementation_method'), "implementationMethod.title")
            ->sortable()->searchable()->collapseOnTablet();

        $columns[] = Column::make(__('yojana::yojana.comment'), "comment")
            ->sortable()->searchable()->collapseOnTablet();

        // Add other columns if needed

        //        $columns = [
        //
        //            Column::make(__('yojana::yojana.consumer_committee'), "consumerCommittee.name")->sortable()->searchable()->collapseOnTablet(),
        //            Column::make(__('yojana::yojana.model'), "implementationMethod.title")->sortable()->searchable()->collapseOnTablet(),
        //            Column::make(__('yojana::yojana.comment'), "comment")->sortable()->searchable()->collapseOnTablet(),
        //            // Column::make(__('yojana::yojana.agreement_application'), "agreement_application")->sortable()->searchable()->collapseOnTablet(),
        //            // Column::make(__('yojana::yojana.agreement_recommendation_letter'), "agreement_recommendation_letter")->sortable()->searchable()->collapseOnTablet(),
        //            // Column::make(__('yojana::yojana.deposit_voucher'), "deposit_voucher")->sortable()->searchable()->collapseOnTablet(),
        //        ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';
                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
                if (can('plan print')) {
                    // Agreement Instruction Letter
                    $agreementBtn = '<button type="button" class="btn btn-info btn-sm" title="' . __('yojana::yojana.agreement_instruction') . '" wire:click="printAgreementInstruction(' . $row->id . ')"><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $agreementBtn;

                    // Tender Approval Letter
                    $tenderBtn = '<button type="button" class="btn btn-success btn-sm" title="' . __('yojana::yojana.tender_approval_letter') . '" wire:click="printTenderApproval(' . $row->id . ')"><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $tenderBtn;
                    
                    // Rate Submission Letter
                    $rateSubmissionBtn = '<button type="button" class="btn btn-secondary btn-sm" title="' . __('yojana::yojana.rate_submission_letter') . '" wire:click="printRateSubmission(' . $row->id . ')"><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $rateSubmissionBtn;
                    
                    // Tender Opening Minute
                    $tenderOpeningBtn = '<button type="button" class="btn btn-warning btn-sm" title="' . __('yojana::yojana.tender_opening_minute') . '" wire:click="printTenderOpeningMinute(' . $row->id . ')"><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $tenderOpeningBtn;
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
        if (!can('plan edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        // return redirect()->route('admin.implementation_agencies.edit', ['id' => $id]);
        $this->dispatch('edit-implementation-agencies', $id);
    }

    public function print($id)
    {
        $service = new ImplementationAgencyAdminService();
        $workOrder = $service->getWorkOrder( $id);
        if (!isset($workOrder)){
            $this->errorFlash('Letter Sample Not Found');
            return false;
        }
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    public function printAgreementInstruction($id)
    {
        $service = new ImplementationAgencyAdminService();
        $workOrder = $service->getWorkOrderByType($id, LetterTypes::AgreementInstruction);
        if (!isset($workOrder)){
            $this->errorFlash(__('yojana::yojana.letter_format_missing'));
            return false;
        }
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    public function printTenderApproval($id)
    {
        $service = new ImplementationAgencyAdminService();
        $workOrder = $service->getWorkOrderByType($id, LetterTypes::TenderApprovalLetter);
        if (!isset($workOrder)){
            $this->errorFlash(__('yojana::yojana.letter_format_missing'));
            return false;
        }
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    public function printRateSubmission($id)
    {
        $service = new ImplementationAgencyAdminService();
        $workOrder = $service->getWorkOrderByType($id, LetterTypes::RateSubmissionLetter);
        if (!isset($workOrder)){
            $this->errorFlash(__('yojana::yojana.letter_format_missing'));
            return false;
        }
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    public function printTenderOpeningMinute($id)
    {
        $service = new ImplementationAgencyAdminService();
        $workOrder = $service->getWorkOrderByType($id, LetterTypes::TenderOpeningMinute);
        if (!isset($workOrder)){
            $this->errorFlash(__('yojana::yojana.letter_format_missing'));
            return false;
        }
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id, 'model_id' => $id ]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }
    public function delete($id)
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ImplementationAgencyAdminService();
        $service->delete(ImplementationAgency::findOrFail($id));
        $this->successFlash(__('yojana::yojana.implementation_agency_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ImplementationAgencyAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ImplementationAgenciesExport($records), 'implementation_agencies.xlsx');
    }
}
