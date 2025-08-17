<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\PlansExport;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\PlanAdminService;

class ClosedPlansTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Plan::class;
    public $area_id;
    public $budgetHead_id;
    public $expenseHead_id;
    public $planType;
    public $projectGroup_id;
    public $implementationLevel_id;
    public $report = false;

    public function mount($report = false)
    {
        $this->report = $report; //get true value from the agreed plan form table as it indicates report
    }

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    protected $listeners = ['search' => 'searchData'];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_plans.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_plans.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function searchData($area_id, $budgetHead_id, $expenseHead_id, $planType, $projectGroup_id, $implementationLevel_id)
    {
        $this->area_id = $area_id;
        $this->budgetHead_id = $budgetHead_id;
        $this->expenseHead_id = $expenseHead_id;
        $this->planType = $planType;
        $this->projectGroup_id = $projectGroup_id;
        $this->implementationLevel_id = $implementationLevel_id;
    }

    public function builder(): Builder
    {
        return Plan::query()
            ->select('*')
            ->with([
                'implementationMethod',
                'planArea',
                'subRegion',
                'target',
                'implementationLevel',
                'projectGroup',
                'sourceType',
                'program',
                'budgetHead',
                'expenseHead',
                'ward',
                'fiscalYear'
            ])
            ->where('pln_plans.status','Completed')
            ->where('pln_plans.deleted_at', null)
            ->where('pln_plans.deleted_by', null)
            ->when($this->area_id, function ($query) {
                $query->where('area_id', $this->area_id);
            })
            ->when($this->budgetHead_id, function ($query) {
                $query->where('budget_head_id', $this->budgetHead_id);
            })
            ->when($this->expenseHead_id, function ($query) {
                $query->where('expense_head_id', $this->expenseHead_id);
            })
            ->when($this->planType, function ($query) {
                $query->where('plan_type', $this->planType);
            })
            ->when($this->projectGroup_id, function ($query) {
                $query->where('project_group_id', $this->projectGroup_id);
            })
            ->when($this->implementationLevel_id, function ($query) {
                $query->where('implementation_level_id', $this->implementationLevel_id);
            })
            ->orderBy('pln_plans.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [

            Column::make(__('yojana::yojana.project_info'))->label(function ($row) {
                $projectName = $row->project_name ?? "N/A";
                $method = $row->implementationMethod->title ?? "N/A";
                $location = $row->location ?? "N/A";

                return '
                    <strong>' . __('yojana::yojana.plan') . ':</strong> ' . $projectName . '<br>
                    <strong>' . __('yojana::yojana.implementation_method') . ':</strong> ' . $method . '<br>
                    <strong>' . __('yojana::yojana.location') . ':</strong> ' . $location . '
                ';

            })->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.location'))->label(function ($row) {
                $ward = $row->ward->ward_name_ne ?? "N/A";
                $implementationLevel = $row->implementationLevel->title ?? "N/A";
                $implementationMethod = $row->implementationMethod->title ?? "N/A";

                return '
                    <strong>' . __('yojana::yojana.ward') . ':</strong> ' . $ward . '<br>
                    <strong>' . __('yojana::yojana.implementation_level') . ':</strong> ' . $implementationLevel . '<br>
                    <strong>' . __('yojana::yojana.implementation_method') . ':</strong> ' . $implementationMethod . '
                ';
            })->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.region_info'))->label(function ($row) {
                $area = $row->planArea->area_name ?? "N/A";
                $subRegion = $row->subRegion->name ?? "N/A";
                $target = $row->target->title ?? "N/A";

                return '
                <strong>' . __('yojana::yojana.area') . ':</strong> ' . $area . '<br>
                <strong>' . __('yojana::yojana.sub_region') . ':</strong> ' . $subRegion . '<br>
                <strong>' . __('yojana::yojana.target') . ':</strong> ' . $target . '
            ';

            })->html()->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.budget'))->label(function ($row) {
                $allocated = __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->allocated_budget ?? 0), true);
                $remaining = __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->remaining_budget ?? 0), true);

                return '
            <strong>' . __('yojana::yojana.allocated') . ':</strong> ' . $allocated . '<br>
            <strong>' . __('yojana::yojana.remaining') . ':</strong> ' . $remaining . '<br>
            ';

            })->html()->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.status'))
                ->label(function ($row) {
                    $status = $row->status->label() ?? 'N/A';

                    $badgeClass = match ($status) {
                        'Plan Entry' => 'badge bg-primary',
                        'Project Incharge Appointed' => 'badge bg-success',
                        'Cost Estimation Entry' => 'badge bg-info',
                        'Target Entry' => 'badge bg-warning text-dark',
                        default => 'badge bg-secondary',
                    };

                    return "<span class='{$badgeClass}'>{$status}</span>";
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            // Column::make(__('yojana::yojana.project_name'), "project_name")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.implementation_method'), "implementationMethod.title")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.location'), "location")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.ward'), "ward.ward_name_en")->sortable()->searchable()->collapseOnTablet(),

            // Column::make(__('yojana::yojana.start_fiscal_year'), "fiscalYear.year")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.operate_fiscal_year'), "fiscalYear.year")->sortable()->searchable()->collapseOnTablet(),

            // Column::make(__('yojana::yojana.area'), "planArea.area_name")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('yojana::yojana.sub_region'), "subRegion.name")->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.target'), "target.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.implementation_level'), "implementationLevel.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.plan_type'), "plan_type") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.nature'), "nature") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.project_group'), "projectGroup.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.purpose'), "purpose") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.red_book_detail'), "red_book_detail") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.source'), "sourceType.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.program'), "program") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.budget_head'), "budgetHead.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.expense_head'), "expenseHead.title") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.fiscal_year'), "fiscalYear.year") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.amount'), "amount") ->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan show')) {
                    $show = '<button class="btn btn-secondary btn-sm" wire:click="show(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $show;
                }
                if (!$this->report) { //show this button only if it is not from the report
                    if (can('plan edit')) {
                        $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                        $buttons .= $edit;
                    }
                    if (can('plan delete')) {
                        $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $delete;
                    }
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
        return redirect()->route('admin.plans.edit', ['id' => $id]);
    }
    public function show($id)
    {
        if (!can('plan show')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.plans.show', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAdminService();
        $service->delete(Plan::findOrFail($id));
        $this->successFlash(__('yojana::yojana.plan_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PlansExport($records), 'plans.xlsx');
    }
}
