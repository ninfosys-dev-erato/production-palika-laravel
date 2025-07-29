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
use Src\Yojana\Models\Evaluation;
use Src\Yojana\Service\EvaluationAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class EvaluationTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Evaluation::class;
    public $plan;
    public $planId = null;
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
    public function mount($plan = null)
    {
        if ($plan) {
            $this->plan = $plan;
            $this->planId = $plan->id;
        }
    }
    public function builder(): Builder
    {
        return Evaluation::query()
            ->select('*')
            ->where('deleted_at', null)
            ->where('deleted_by', null)
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
            // Column::make(__('yojana::yojana.plan_id'), "plan_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.evaluation_timing'))->label(function ($row) {
                $evaluationDate = $row->evaluation_date ?? "N/A";
                $completionDate = $row->completion_date ?? "N/A";
                return "
                    <strong>".__('yojana::yojana.evaluation_date').":</strong> {$evaluationDate} <br>
                    <strong>".__('yojana::yojana.completion_date').":</strong> {$completionDate}
                ";
            })->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.installment_info'))->label(function ($row) {
                $installmentNo = $row->installment_no->label() ?? "N/A";
                $evaluationAmount = __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->evaluation_amount ?? 0), true);
                return "
                    <strong>".__('yojana::yojana.installment').":</strong> {$installmentNo} <br>
                    <strong>".__('yojana::yojana.amount').":</strong> {$evaluationAmount}
                ";
            })->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.testing_date'), "testing_date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.attendance_number'), "attendance_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.evaluation_no'), "evaluation_no")->sortable()->searchable()->collapseOnTablet()
            ->format(fn($value) => replaceNumbersWithLocale($value, true)),


            // Column::make(__('yojana::yojana.up_to_date_amount'), "up_to_date_amount")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.is_implemented'), "is_implemented")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.is_budget_utilized'), "is_budget_utilized")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.is_quality_maintained'), "is_quality_maintained")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.is_reached'), "is_reached")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.is_tested'), "is_tested")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.ward_recommendation_document'), "ward_recommendation_document")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.technical_evaluation_document'), "technical_evaluation_document")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.committee_report'), "committee_report")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.attendance_report'), "attendance_report")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.construction_progress_photo'), "construction_progress_photo")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.work_completion_report'), "work_completion_report")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.expense_report'), "expense_report")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.other_document'), "other_document")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="payment(' . $row->id . ')" ><i class="bx bx-money"></i></button>&nbsp;';
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
    public function refresh() {}
    public function edit($id)
    {
        if (!can('plan edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-evaluation', evaulationId: $id);
        // return redirect()->route('admin.evaluations.edit', ['id' => $id, 'planId' => $this->planId]);
    }

    public function payment($id)
    {
        $this->dispatch('load-evaluation-payment', $id);
    }

    public function delete($id)
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EvaluationAdminService();
        $service->delete(Evaluation::findOrFail($id));
        $this->successFlash(__('yojana::yojana.evaluation_deleted_successfully'));
    }
    
    public function deleteSelected()
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EvaluationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'evaluations.xlsx');
    }
}
