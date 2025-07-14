<?php

namespace Src\TaskTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\EmployeeMarkingScores\Exports\EmployeeMarkingScoresExport;
use Src\TaskTracking\Models\EmployeeMarkingScore;
use Src\TaskTracking\Service\EmployeeMarkingScoreAdminService;

class EmployeeMarkingScoreTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = EmployeeMarkingScore::class;
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
        return EmployeeMarkingScore::query()
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
            Column::make(__('tasktracking::tasktracking.employee_marking_id'), "employee_marking_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.criteria_id'), "criteria_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.score_obtained'), "score_obtained") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.score_out_of'), "score_out_of") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('employee_marking_scores edit') || can('employee_marking_scores delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('employee_marking_scores edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('employee_marking_scores delete')) {
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
        if(!can('employee_marking_scores edit')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.employee_marking_scores.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('employee_marking_scores delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new EmployeeMarkingScoreAdminService();
        $service->delete(EmployeeMarkingScore::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.employee_marking_score_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('employee_marking_scores delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new EmployeeMarkingScoreAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new EmployeeMarkingScoresExport($records), 'employee_marking_scores.xlsx');
    }
}
