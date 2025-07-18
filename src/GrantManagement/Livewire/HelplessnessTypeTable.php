<?php

namespace Src\GrantManagement\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\GrantManagement\Exports\GrantManagementExport;
use Src\GrantManagement\Models\HelplessnessType;
use Src\GrantManagement\Service\HelplessnessTypeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class HelplessnessTypeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = HelplessnessType::class;
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
        return HelplessnessType::query()
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
            Column::make(__('grantmanagement::grantmanagement.helplessness_type'), "helplessness_type") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.helplessness_type_en'), "helplessness_type_en") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('helplessness_types edit') || can('helplessness_types delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('helplessness_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('helplessness_types delete')) {
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
        if(!can('helplessness_types edit')){
               SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
               return false;
        }
        $this->dispatch('edit-helplessness-type', $id);
        
        // return redirect()->route('admin.helplessness_types.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('helplessness_types delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new HelplessnessTypeAdminService();
        $service->delete(HelplessnessType::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.helplessness_type_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('helplessness_types delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new HelplessnessTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'helplessness-types.xlsx');
    }
}
