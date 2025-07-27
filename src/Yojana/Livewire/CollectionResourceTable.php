<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\CollectionResourcesExport;
use Src\Yojana\Models\CollectionResource;
use Src\Yojana\Service\CollectionResourceAdminService;

class CollectionResourceTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = CollectionResource::class;
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
        return CollectionResource::query()
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
            Column::make("Model Type", "model_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Model Id", "model_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Collectable", "collectable") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Type", "type") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Quantity", "quantity") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Rate Type", "rate_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Rate", "rate") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan_basic_settings edit') || can('plan_basic_settings delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan_basic_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_basic_settings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
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
        if(!can('plan_basic_settings edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.collection_resources.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('plan_basic_settings delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new CollectionResourceAdminService();
        $service->delete(CollectionResource::findOrFail($id));
        $this->successFlash("Collection Resource Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('plan_basic_settings delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new CollectionResourceAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CollectionResourcesExport($records), 'collection_resources.xlsx');
    }
}
