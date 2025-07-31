<?php

namespace Src\Wards\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Wards\Exports\WardsExport;
use Src\Wards\Models\Ward;
use Src\Wards\Service\WardAdminService;

class WardTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Ward::class;
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
        return Ward::query()
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
            Column::make("Local Body Id", "local_body_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Phone", "phone") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Email", "email") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Address En", "address_en") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Address Ne", "address_ne") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Ward Name En", "ward_name_en") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Ward Name Ne", "ward_name_ne") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('wards edit') || can('wards delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('wards edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('wards delete')) {
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
        if(!can('wards edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.wards.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('wards delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new WardAdminService();
        $service->delete(Ward::findOrFail($id));
        $this->successFlash("Ward Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('wards delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new WardAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new WardsExport($records), 'wards.xlsx');
    }
}
