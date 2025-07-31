<?php

namespace Src\TokenTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\TokenTracking\Exports\TokenHoldersExport;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\TokenHolderAdminService;

class TokenHolderTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = TokenHolder::class;
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
        return TokenHolder::query()
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
            Column::make(__('tokentracking::tokentracking.name'), "name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tokentracking::tokentracking.email'), "email") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tokentracking::tokentracking.mobile_no'), "mobile_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tokentracking::tokentracking.address'), "address") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('token_holders edit') || can('token_holders delete')) {
            $actionsColumn = Column::make(__('tokentracking::tokentracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('token_holders edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('token_holders delete')) {
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
        if(!can('token_holders edit')){
               SessionFlash::WARNING_FLASH(__('tokentracking::tokentracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.token_holders.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('token_holders delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new TokenHolderAdminService();
        $service->delete(TokenHolder::findOrFail($id));
        $this->successFlash(__('tokentracking::tokentracking.token_holder_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('token_holders delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new TokenHolderAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokenHoldersExport($records), 'token_holders.xlsx');
    }
}
