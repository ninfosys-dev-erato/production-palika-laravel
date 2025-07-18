<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\ItemsExport;
use Src\Yojana\Models\Item;
use Src\Yojana\Service\ItemAdminService;

class ItemTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = Item::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_items.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_items.id'])
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
        return Item::query()
            ->with('type','unit')
            ->where('pln_items.deleted_at',null)
            ->where('pln_items.deleted_by',null)
           ->orderBy('pln_items.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__('yojana::yojana.title'), "title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.type'), "Type.title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.code'), "code") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.unit'), "unit.title") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.remarks'), "remarks") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('items edit') || can('items delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';


                if (can('items edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('items delete')) {
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
        if(!can('items edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.items.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('items delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ItemAdminService();
        $service->delete(Item::findOrFail($id));
        $this->successFlash(__('yojana::yojana.item_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('items delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ItemAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ItemsExport($records), 'items.xlsx');
    }
}
