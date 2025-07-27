<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Exports\ImplementationMethodsExport;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Service\ImplementationMethodAdminService;

class ImplementationMethodTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = ImplementationMethod::class;

    public $plans;
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
        $query =  ImplementationMethod::query()
            ->with('plans.implementationMethod')
            ->select('*')
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things

        $this->plans = $query->get()[0]->plans;
        return $query;
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.code'), "code")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.model'))
                ->label(function ($row) {
                    return $row->model?->label();
                })->html()
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.total_plans'))
                ->label(function ($row) {
                    $totalPlans = $this->plans->where('implementationMethod.model',$row->model->value);
                    return replaceNumbersWithLocale(count($totalPlans), true);
                })->html()
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.operating_plans'))
                ->label(function ($row) {
                    $operatingPlans = $this->plans
                        ->where('implementationMethod.model',$row->model->value)
                        ->where('status','!=' ,PlanStatus::Completed);
                    return replaceNumbersWithLocale(count($operatingPlans), true);
                })->html()
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.completed_plans'))
                ->label(function ($row) {
                    $completedPlans = $this->plans
                        ->where('implementationMethod.model',$row->model->value)
                        ->where('status','=' ,PlanStatus::Completed);
                    return replaceNumbersWithLocale(count($completedPlans), true);
                })->html()
        ];
        if (can('plan_basic_settings edit') || can('plan_basic_settings delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('plan_basic_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_basic_settings delete')) {
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
        if (!can('plan_basic_settings edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-implementationMethod', implementationMethod: $id);
        // return redirect()->route('admin.implementation_methods.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ImplementationMethodAdminService();
        $service->delete(ImplementationMethod::findOrFail($id));
        $this->successFlash(__('yojana::yojana.implementation_method_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ImplementationMethodAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ImplementationMethodsExport($records), 'implementation_methods.xlsx');
    }
}
