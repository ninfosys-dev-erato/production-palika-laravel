<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Exports\CustomerLandDetailsExport;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Service\CustomerLandDetailService;

class CustomerLandDetailTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = CustomerLandDetai::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('ebps_customer_land_details.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['ebps_customer_land_details.id'])
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
        return CustomerLandDetail::query()
            ->with('localBody')
            ->select('ward','tole','former_local_body','former_ward_no')
            ->where('ebps_customer_land_details.deleted_at',null)
            ->where('ebps_customer_land_details.deleted_by',null)
           ->orderBy('ebps_customer_land_details.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__("ebps::ebps.local_body"), "localBody.title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.ward_tole"), "ward")
            ->label(fn ($row) => "{$row->tole}-{$row->ward}")
            ->sortable()
            ->searchable()
            ->collapseOnTablet(),
            Column::make(__("Former Local Body"), "former_local_body") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Former Ward No"), "former_ward_no") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.area_sqm"), "area_sqm") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.lot_no"), "lot_no") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.seat_no"), "seat_no") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.ownership"), "ownership") ->sortable()->searchable()->collapseOnTablet(),
        ];

            $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
                $buttons = '';
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;


                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        return redirect()->route('customer.ebps.land-detail-edit',['id'=>$id]);
    }
    public function delete($id)
    {

        $service = new CustomerLandDetailService();
        $service->delete(CustomerLandDetail::findOrFail($id));
        $this->successFlash(__("ebps::ebps.customer_land_detai_deleted_successfully"));
    }
    public function deleteSelected(){

        $service = new CustomerLandDetailService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CustomerLandDetailsExport($records), 'customer_land_details.xlsx');
    }
}
