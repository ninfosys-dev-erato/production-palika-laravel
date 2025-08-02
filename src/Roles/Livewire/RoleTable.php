<?php

namespace Src\Roles\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Roles\Exports\RolesExport;
use Src\Roles\Models\Role;
use Src\Roles\Service\RoleAdminService;

class RoleTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Role::class;
    public array $bulkActions = [

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
        return  Role::query()
            ->orWhere('name', '!=', 'super-admin')
            ->orWhere('guard_name', '===', 'web')
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->orderBy('created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__("Name"), "name"),
            Column::make(__("Guard Name"), "guard_name"),
        ];

        if (can('roles update') || can('roles delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('roles update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('roles delete')) {
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
        return redirect()->route('admin.roles.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('roles delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RoleAdminService();
        $service->delete(Role::findOrFail($id));
        $this->successFlash("Role Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('roles delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RoleAdminService();
        foreach ($this->getSelected() as $itemId) {
            $service->delete(Role::findOrFail($itemId));
        }
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new RolesExport($records), 'roles.xlsx');
    }
}
