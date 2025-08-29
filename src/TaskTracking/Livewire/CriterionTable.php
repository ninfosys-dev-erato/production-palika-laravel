<?php

namespace Src\TaskTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSortable;
use Src\TaskTracking\Exports\CriteriaExport;
use Src\TaskTracking\Models\Criterion;
use Src\TaskTracking\Service\CriterionAdminService;

class CriterionTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Criterion::class;
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
        return Criterion::query()
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
            Column::make(__('tasktracking::tasktracking.name'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.name_en'), "name_en")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.max_score'), "max_score")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tasktracking::tasktracking.min_score'), "min_score")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('tsk_setting edit') || can('tsk_setting delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('tsk_setting edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('tsk_setting delete')) {
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
        if (!can('tsk_setting edit')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.criteria.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('tsk_setting delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new CriterionAdminService();
        $service->delete(Criterion::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.criterion_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('tsk_setting delete')) {
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new CriterionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CriteriaExport($records), 'criteria.xlsx');
    }
}
