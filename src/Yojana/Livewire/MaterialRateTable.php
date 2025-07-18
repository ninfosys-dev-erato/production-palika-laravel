<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\MaterialRatesExport;
use Src\Yojana\Models\MaterialRate;
use Src\Yojana\Service\MaterialRateAdminService;

class MaterialRateTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = MaterialRate::class;
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
        return MaterialRate::query()
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
            Column::make("Material Id", "material_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Fiscal Year Id", "fiscal_year_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Is Vat Included", "is_vat_included") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Is Vat Needed", "is_vat_needed") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Referance No", "referance_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Royalty", "royalty") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('material_rates edit') || can('material_rates delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('material_rates edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('material_rates delete')) {
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
        if(!can('material_rates edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.material_rates.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('material_rates delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new MaterialRateAdminService();
        $service->delete(MaterialRate::findOrFail($id));
        $this->successFlash("Material Rate Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('material_rates delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new MaterialRateAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MaterialRatesExport($records), 'material_rates.xlsx');
    }
}
