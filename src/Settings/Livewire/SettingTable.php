<?php

namespace Src\Settings\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Settings\Exports\SettingsExport;
use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;
use Src\Settings\Service\MstSettingAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class SettingTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = MstSetting::class;
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
        return MstSetting::query()
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
            Column::make("Group Id", "group_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.label'), "label") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.value'), "value") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.key_id'), "key_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.key_type'), "key_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.key_needle'), "key_needle") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.key'), "key") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('settings::settings.description'), "description") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('settings edit') || can('settings delete')) {
            $actionsColumn = Column::make(__('settings::settings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('settings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
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
        if(!can('settings edit')){
               SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.settings.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('settings delete')){
                SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
                return false;
        }
        $service = new MstSettingAdminService();
        $service->delete(Setting::findOrFail($id));
        $this->successFlash(__('settings::settings.setting_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('settings delete')){
                    SessionFlash::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new MstSettingAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new SettingsExport($records), 'settings.xlsx');
    }
}
