<?php

namespace Src\TaskTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\TaskTracking\DTO\ActivityAdminDto;
use Src\TaskTracking\Enums\TaskStatus;
use Src\TaskTracking\Exports\TasksExport;
use Src\TaskTracking\Models\Project;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Models\TaskType;
use Src\TaskTracking\Service\ActivityAdminService;
use Src\TaskTracking\Service\EmployeeMarkingAdminService;
use Src\TaskTracking\Service\TaskAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\TaskTracking\Models\EmployeeMarking;

class ReportAnusuchiTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Task::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('tsk_employee_markings.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['tsk_employee_markings.id'])
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
        return EmployeeMarking::query()
            ->select('*')
            ->with(['employeeMarkingScore', 'user', 'anusuchi'])
            ->where('tsk_employee_markings.deleted_at', null)
            ->where('tsk_employee_markings.deleted_by', null)
            ->orderBy('tsk_employee_markings.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('tasktracking::tasktracking.employee'), "user.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.anusuchi'), "anusuchi.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.fiscal_year'), "fiscal_year")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.date'), "date_from")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.month'), "month")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->label(function ($row) {
                    return $row->month ? nepaliMonthName($row->month) : 'N/A';
                }),
            Column::make(__('tasktracking::tasktracking.full_score'), "full_score")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.obtained_score'), "obtained_score")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('tsk_management edit') || can('tsk_management delete') || can('tsk_management print')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('tsk_management edit')) {
                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('tsk_management print')) {
                    $print = '<button class="btn btn-info btn-sm" wire:click="print(' . $row->id . ')" ><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $print;
                }

                if (can('tsk_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('tsk_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('tsk_management edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.anusuchis.editReport', ['id' => $id]);
    }
    public function view($id)
    {
        if (!can('tsk_management edit')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.anusuchis.viewReport', ['id' => $id]);
    }
    public function print($id)
    {
        if (!can('tsk_management print')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.anusuchis.printReport', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('tsk_management delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new EmployeeMarkingAdminService();
        $service->delete(EmployeeMarking::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('tsk_management delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new TaskAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TasksExport($records), 'tasks.xlsx');
    }
}
