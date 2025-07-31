<?php

namespace Src\Settings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Settings\Exports\SettingGroupsExport;
use Src\Settings\Models\SettingGroup;
use Src\Settings\Service\SettingGroupAdminService;

class SettingGroupTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = SettingGroup::class;
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
        return SettingGroup::query()
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
            Column::make(__('settings::settings.group_name'), "group_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.description'), "description") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.slug'), "slug") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('setting_groups edit') || can('setting_groups delete')) {
            $actionsColumn = Column::make(__('settings::settings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('setting_groups edit')) {
                    $edit = '<button class="btn btn-success btn-sm" wire:click="manage(' . $row->id . ')" ><i class="bx bx-cog"></i></button>&nbsp;';
                    $edit .= '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('setting_groups delete')) {
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
        if(!can('setting_groups edit')){
               SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.setting_groups.edit',['id'=>$id]);
    }
    public function manage($id)
    {
        if(!can('setting_groups edit')){
            SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.setting_groups.manage',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('setting_groups delete')){
                SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
                return false;
        }
        $service = new SettingGroupAdminService();
        $service->delete(SettingGroup::findOrFail($id));
        $this->successFlash(__('settings::settings.setting_group_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('setting_groups delete')){
                    SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new SettingGroupAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new SettingGroupsExport($records), 'setting_groups.xlsx');
    }
}
