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
use Src\GrantManagement\Models\CooperativeType;
use Src\GrantManagement\Service\CooperativeTypeAdminService;

class CooperativeTypeTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = CooperativeType::class;
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
        return CooperativeType::query()
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
            Column::make(__('grantmanagement::grantmanagement.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('grantmanagement::grantmanagement.title_en'), "title_en") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('cooperative_types edit') || can('cooperative_types delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('cooperative_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('cooperative_types delete')) {
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
        if(!can('cooperative_types edit')){
               SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
               return false;
        }
        
        $this->dispatch('edit-cooperative-type', $id);
        // return redirect()->route('admin.cooperative_types.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('cooperative_types delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new CooperativeTypeAdminService();
        $service->delete(CooperativeType::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.cooperative_type_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('cooperative_types delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new CooperativeTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'cooperative-types.xlsx');
    }
}
