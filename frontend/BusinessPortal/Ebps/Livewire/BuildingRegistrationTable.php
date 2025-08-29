<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Exports\MapAppliesExport;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Service\MapApplyAdminService;
use Src\Ebps\Service\ApplicationStepService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSortable;

class BuildingRegistrationTable extends DataTableComponent
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
         ->whereIn('ebps_map_applies.id', $mapApplyIds)
        ->select('full_name', 'mobile_no', 'province_id', 'local_body_id', 'district_id', 'ward_no', 'house_owner_id')
            ->where('ebps_map_applies.deleted_at',null)
            ->where('ebps_map_applies.deleted_by',null)
        ->where('application_type', ApplicationTypeEnum::BUILDING_DOCUMENTATION)
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

                // Check if first step has been approved using the service
                $firstStepApproved = $this->applicationStepService->isFirstStepApprovedForBuildingRegistration($row->id);

                // Only show edit and delete buttons if first step is not approved
                if (!$firstStepApproved) {
                    $edit = '<button type="button" class="btn btn-primary btn-sm"  wire:click="edit(' . $row->id . ')"><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                    $delete = '<button type="button" class="btn btn-danger btn-sm"  wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                }

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
        return redirect()->route('organization.ebps.building-registrations.edit',['id'=>$id]);
    }
    public function chooseOrganization($id)
    {
        $this->dispatch('open-choose-organization-modal', id: $id);
    }


    public function moveFurther($id)
    {
        return redirect()->route('organization.ebps.building-registrations.step', ['id'=>$id]);
    }

    public function view($id)
    {
        return redirect()->route('organization.ebps.building-registrations.view',['id'=>$id]);
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
