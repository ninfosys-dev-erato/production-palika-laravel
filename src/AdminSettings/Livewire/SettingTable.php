<?php

namespace Src\AdminSettings\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\AdminSettings\Models\AdminSetting;
use Src\AdminSettings\Service\AdminSettingService;
use Src\AdminSettings\Models\User;

class SettingTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = AdminSetting::class;

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
        return AdminSetting::query()
            ->orderBy('label', 'asc')
            ->with(['createdBy', 'updatedBy', 'group']);
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('adminsettings::adminsettings.group'), "group_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('adminsettings::adminsettings.label'), "label")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('adminsettings::adminsettings.value'), "value")->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('setting_update') || can('setting_delete')) {
            $actionsColumn = Column::make(__('adminsettings::adminsettings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('setting_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('setting_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function edit($id)
    {
        if (!can('setting_update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.admin_setting.setting.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('setting_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdminSettingService();
        $service->delete(AdminSetting::findOrFail($id));
        $this->successFlash("setting_deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('setting_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AdminSettingService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
}
