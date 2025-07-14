<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;


use Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Exports\MapAppliesExport;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\Organization;
use Src\Ebps\Service\MapApplyAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class CustomerMapApplyTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = MapApply::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('ebps_map_applies.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['ebps_map_applies.id'])
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
        return MapApply::query()
            ->where('mobile_no', Auth::guard('customer')->user()->mobile_no)
            ->with(['fiscalYear', 'customer', 'landDetail', 'constructionType', 'mapApplySteps', 'houseOwner', 'localBody', 'district'])
            ->select('full_name', 'mobile_no', 'province_id', 'local_body_id', 'district_id', 'ward_no')
            ->where('application_type', ApplicationTypeEnum::MAP_APPLIES)
            ->where('ebps_map_applies.deleted_at',null)
            ->where('ebps_map_applies.deleted_by',null)
            ->orderBy('ebps_map_applies.created_at','DESC'); // Select some things
        }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ebps::ebps.submission_no'), "submission_id") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.fiscal_year'), "fiscalYear.year") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.construction_type"), "constructionType.title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("ebps::ebps.usage"), "usage")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(fn($value) => PurposeOfConstructionEnum::tryFrom($value)?->label() ?? '-'),

            Column::make(__("ebps::ebps.house_owner"))->label(
                fn($row, Column $column) => view('Ebps::livewire.table.col-house-owner-detail', [
                    'row' => $row,
                ])->render()
            )->html(),
            Column::make(__("ebps::ebps.applied_date"), "applied_date") ->sortable()->searchable()->collapseOnTablet(),
        ];

        $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
            $buttons = '';
                $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="हेर्नुहोस्"><i class="bx bx-show"></i></button>&nbsp;';
                $buttons .= $view;
                $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="सम्पादन गर्नुहोस्"><i class="bx bx-edit"></i></button>&nbsp;';
                $buttons .= $edit;
                $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="परामर्शदाता छान्नुहोस्"><i class="bx bx-trash"></i></button>&nbsp;';
                $buttons .= $delete;
                $organization = '<button type="button" class="btn btn-secondary btn-sm" wire:click="chooseOrganization(' . $row->id . ')"  data-bs-toggle="modal"
                                data-bs-target="#indexModal"><i class="bx bx-building"></i></button>&nbsp;';
                $buttons .= $organization;

                $moveForward = '<button type="button" class="btn btn-info btn-sm" wire:click="moveFurther(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="अगाडि बढ्नुहोस्"><i class="bx bx-right-arrow-alt"></i></button>&nbsp;';
                $buttons .= $moveForward;
            return $buttons;
        })->html();
        $columns[] = $actionsColumn;

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        return redirect()->route('customer.ebps.apply.map-apply.edit',['id'=>$id]);
    }
    public function view($id)
    {
        return redirect()->route('customer.ebps.apply.map-apply.show',['id'=>$id]);
    }
    public function chooseOrganization($id)
    {
        $this->dispatch('open-choose-organization-modal', id: $id);
    }

    public function moveFurther($id)
    {
        return redirect()->route('customer.ebps.apply.step', ['id'=>$id]);
    }
    public function delete($id)
    {
        $service = new MapApplyAdminService();
        $service->delete(MapApply::findOrFail($id));
        $this->successFlash(__("ebps::ebps.map_apply_deleted_successfully"));
    }
    public function deleteSelected()
    {
        $service = new MapApplyAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MapAppliesExport($records), 'map_applies.xlsx');
    }
}
