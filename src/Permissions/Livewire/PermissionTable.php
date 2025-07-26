<?php

namespace Src\Permissions\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Permissions\Exports\PermissionsExport;
use Src\Permissions\Models\Permission;
use Src\Permissions\Service\PermissionAdminService;

class PermissionTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Permission::class;
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
        return Permission::query()
            ->where('guard_name', '=', 'web')
            ->orderBy('created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__("Name"), "name")->searchable()->sortable(),
            Column::make(__("Guard Name"), "guard_name"),
        ];
    
        if (can('permissions edit') || can('permissions delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';
    
                if (can('permissions edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
    
                if (can('permissions delete')) {
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
        return redirect()->route('admin.permissions.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('permissions delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PermissionAdminService();
        $service->delete(Permission::findOrFail($id));
        $this->successFlash("Permission Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('permissions delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $service = new PermissionAdminService();
        foreach ($this->getSelected() as $itemId) {
            $service->delete(Permission::findOrFail($itemId));
        }
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PermissionsExport($records), 'permissions.xlsx');
    }
}
