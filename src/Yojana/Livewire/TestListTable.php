<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Yojana\Exports\TestListsExport;
use Src\Yojana\Models\TestList;
use Src\Yojana\Service\TestListAdminService;

class TestListTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = TestList::class;
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
        return TestList::query()
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
Column::make(__('yojana::yojana.type'), "type") ->sortable()->searchable()->collapseOnTablet(),
 BooleanColumn::make(__('yojana::yojana.is_for_agreement'), "is_for_agreement") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('test_lists edit') || can('test_lists delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('test_lists edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('test_lists delete')) {
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
        if(!can('test_lists edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
//        return redirect()->route('admin.test_lists.edit',['id'=>$id]);
        $this->dispatch('edit-test-list',testList :$id);

    }
    public function delete($id)
    {
        if(!can('test_lists delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new TestListAdminService();
        $service->delete(TestList::findOrFail($id));
        $this->successFlash(__('yojana::yojana.test_list_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('test_lists delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new TestListAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TestListsExport($records), 'test_lists.xlsx');
    }
}
