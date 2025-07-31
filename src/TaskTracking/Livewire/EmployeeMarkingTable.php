<?php

namespace Src\TaskTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\TaskTracking\Exports\EmployeeMarkingsExport;
use Src\TaskTracking\Models\EmployeeMarking;
use Src\TaskTracking\Service\EmployeeMarkingAdminService;

class EmployeeMarkingTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = EmployeeMarking::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
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
        return EmployeeMarking::query()
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
            Column::make(__('tasktracking::tasktracking.employee_id'), "employee_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.anusuchi_id'), "anusuchi_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.criteria_id'), "criteria_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.score'), "score") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.fiscal_year'), "fiscal_year") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.period_title'), "period_title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.period_type'), "period_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.date_from'), "date_from") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.date_to'), "date_to") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('employee_markings edit') || can('employee_markings delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('employee_markings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('employee_markings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('employee_markings edit')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.employee_markings.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('employee_markings delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new EmployeeMarkingAdminService();
        $service->delete(EmployeeMarking::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.employee_marking_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('employee_markings delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new EmployeeMarkingAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new EmployeeMarkingsExport($records), 'employee_markings.xlsx');
    }
}
