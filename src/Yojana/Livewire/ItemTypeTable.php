<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\ItemTypesExport;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Service\ItemTypeAdminService;

class ItemTypeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = ItemType::class;
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
        return ItemType::query()
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
            Column::make(__('yojana::yojana.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.code'), "code") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.group'), "group") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('item_types edit') || can('item_types delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('item_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('item_types delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('item_types edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        $this->dispatch('edit-item-type',itemType :$id);

    }
    public function delete($id)
    {
        if(!can('item_types delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ItemTypeAdminService();
        $service->delete(ItemType::findOrFail($id));
        $this->successFlash(__('yojana::yojana.item_type_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('item_types delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ItemTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ItemTypesExport($records), 'item_types.xlsx');
    }
}
