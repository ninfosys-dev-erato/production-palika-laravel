<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectGroupsExport;
use Src\Yojana\Models\ProjectGroup;
use Src\Yojana\Service\ProjectGroupAdminService;

class ProjectGroupTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectGroup::class;
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
        return ProjectGroup::query()
            ->with(['planArea', 'sameGroup'])
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
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.group_name'), "group_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->sameGroup ? $row->sameGroup->title : "N/A";
                }),
            Column::make(__('yojana::yojana.area_name'), "area_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->planArea ? $row->planArea->area_name : "N/A";
                }),
            Column::make(__('yojana::yojana.code'), "code")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('project_groups edit') || can('project_groups delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_groups edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_groups delete')) {
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
        if (!can('project_groups edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-projectGroup', projectGroup: $id);
        // return redirect()->route('admin.project_groups.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('project_groups delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ProjectGroupAdminService();
        $service->delete(ProjectGroup::findOrFail($id));
        $this->successFlash(__('yojana::yojana.project_group_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('project_groups delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ProjectGroupAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectGroupsExport($records), 'project_groups.xlsx');
    }
}
