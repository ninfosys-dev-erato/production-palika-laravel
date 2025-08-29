<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Exports\MapAppliesExport;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Service\MapApplyAdminService;
use Src\Ebps\Service\ApplicationStepService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSortable;

class OrganizationMapApplyTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = MapApply::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    protected ApplicationStepService $applicationStepService;

    public function boot(): void
    {
        $this->applicationStepService = new ApplicationStepService();
    }

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
        $organizationId = Auth::guard('organization')->user()?->organization_id;


        $mapApplyIds = MapApplyDetail::where('organization_id', $organizationId)
        ->whereNull('ebps_map_apply_details.deleted_at')
        ->pluck('map_apply_id');

        return MapApply::query()
       ->with(['fiscalYear', 'customer', 'landDetail', 'constructionType', 'mapApplySteps', 'houseOwner', 'localBody', 'district'])
        ->select('full_name', 'mobile_no', 'province_id', 'local_body_id', 'district_id', 'ward_no', 'house_owner_id')
        ->where('application_type', ApplicationTypeEnum::MAP_APPLIES)
        ->whereIn('ebps_map_applies.id', $mapApplyIds)
        ->whereNull('ebps_map_applies.deleted_at')
        ->whereNull('ebps_map_applies.deleted_by')
        ->orderBy('ebps_map_applies.created_at', 'DESC');
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
            Column::make(__('ebps::ebps.construction_type'), "constructionType.title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Usage"), "usage")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(fn($value) => PurposeOfConstructionEnum::tryFrom($value)?->label() ?? '-'),
            Column::make(__('ebps::ebps.house_owner'))->label(
                fn($row, Column $column) => view('Ebps::livewire.table.col-house-owner-detail', [
                    'row' => $row,
                ])->render()
            )->html(),

            Column::make(__('ebps::ebps.applied_date'), "applied_date") ->sortable()->searchable()->collapseOnTablet(),
        ];

        $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
            $buttons = '';
                $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                $buttons .= $view;

                $firstStepApproved = $this->applicationStepService->isFirstStepApprovedForMapApply($row->id);

                if (!$firstStepApproved) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                }

                $additionalForm = '<button type="button" class="btn btn-secondary btn-sm" wire:click="additionalForm(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Additional Form"><i class="bx bx-file"></i></button>&nbsp;';
                $buttons .= $additionalForm;
                $moveForward = '<button type="button" class="btn btn-info btn-sm" wire:click="moveFurther(' . $row->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Move Forward"><i class="bx bx-right-arrow-alt"></i></button>&nbsp;';
                $buttons .= $moveForward;

            return $buttons;
        })->html();

        $columns[] = $actionsColumn;


        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        return redirect()->route('organization.ebps.map_apply.edit',['id'=>$id]);
    }
    public function view($id)
    {
        return redirect()->route('organization.ebps.map_apply.show',['id'=>$id]);
    }
    public function additionalForm($id)
    {
        return redirect()->route('organization.ebps.map_apply.additionalForm',['id'=>$id]);
    }

    public function moveFurther($id)
    {
        return redirect()->route('organization.ebps.map_apply.step', ['id'=>$id]);
    }
    public function delete($id)
    {
        $service = new MapApplyAdminService();
        $service->delete(MapApply::findOrFail($id));
        $this->successFlash(__("Map Apply Deleted Successfully"));
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
