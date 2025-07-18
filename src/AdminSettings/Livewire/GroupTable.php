<?php

namespace Src\AdminSettings\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\AdminSettings\Models\AdminSettingGroup;
use Src\AdminSettings\Service\AdminSettingGroupService;
use Src\Employees\Models\Branch;
use Src\Employees\Service\BranchAdminService;

class GroupTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = AdminSettingGroup::class;
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
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        return AdminSettingGroup::query()
            ->orderBy('group_name','desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('adminsettings::adminsettings.group_name'), "group_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('adminsettings::adminsettings.description'), "description")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('group_update') || can('group_delete')) {
            $actionsColumn = Column::make(__('adminsettings::adminsettings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('group_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('group_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('group_update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.admin_setting.group.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('group_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdminSettingGroupService();
        $service->delete(AdminSettingGroup::findOrFail($id));
        $this->successFlash("group_deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('group_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdminSettingGroupService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

}
