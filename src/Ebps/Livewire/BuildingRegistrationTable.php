<?php

namespace Src\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Exports\MapAppliesExport;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Service\MapApplyAdminService;
use Src\Ebps\Service\ApplicationRoleFilterService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class BuildingRegistrationTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    
    protected $model = MapApply::class;
    protected ApplicationRoleFilterService $roleFilterService;
    
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function boot(): void
    {
        $this->roleFilterService = new ApplicationRoleFilterService();
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
        $query = MapApply::query()
            ->with(['fiscalYear', 'customer', 'landDetail', 'constructionType', 'mapApplySteps', 'houseOwner', 'localBody', 'district'])
            ->select('ebps_map_applies.id', 'full_name', 'mobile_no', 'province_id', 'local_body_id', 'district_id', 'ward_no', 'house_owner_id', 'application_type', 'submission_id')
            ->where('application_type', ApplicationTypeEnum::BUILDING_DOCUMENTATION)
            ->where('ebps_map_applies.deleted_at', null)
            ->where('ebps_map_applies.deleted_by', null)
            ->orderBy('ebps_map_applies.created_at', 'DESC');

        // Apply enhanced role-based filtering based on current step access
        return $this->roleFilterService->filterApplicationsByCurrentStepAccess(
            $query, 
            ApplicationTypeEnum::BUILDING_DOCUMENTATION->value
        );
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
            
            // Add current step and status column
            Column::make(__('ebps::ebps.step_and_status'), "id")->label(
                fn($row, Column $column) => $this->getCurrentStepLabel($row)
            )->html(),
     ];
        if (can('ebps_map_applies edit') || can('ebps_map_applies delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                return $this->getActionButtons($row);
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }

    protected function getCurrentStepLabel($application): string
    {
        $currentStep = $this->roleFilterService->getCurrentStep($application);
        
        if (!$currentStep) {
            return '
                <div class="text-center">
                    <span class="badge bg-success mb-1">✅ ' . __('ebps::ebps.completed') . '</span><br>
                    <small class="text-muted">All steps finished</small>
                </div>
            ';
        }

        // Get step number from form_position
        $stepNumber = $currentStep->form_position ?? 'N/A';
        
        // Get current step record to determine status
        $stepRecord = $application->mapApplySteps()
            ->where('map_step_id', $currentStep->id)
            ->first();
            
        $status = $stepRecord ? $stepRecord->status : 'not_started';
        
        // Status mapping with icons and colors
        $statusConfig = [
            'pending' => ['label' => __('ebps::ebps.pending'), 'class' => 'bg-warning', 'icon' => '⏳'],
            'submitted' => ['label' => __('ebps::ebps.submitted'), 'class' => 'bg-info', 'icon' => '📝'],
            'accepted' => ['label' => __('ebps::ebps.accepted'), 'class' => 'bg-success', 'icon' => '✅'],
            'rejected' => ['label' => __('ebps::ebps.rejected'), 'class' => 'bg-danger', 'icon' => '❌'],
            'not_started' => ['label' => __('ebps::ebps.not_started'), 'class' => 'bg-secondary', 'icon' => '⚪'],
        ];
        
        $statusInfo = $statusConfig[$status] ?? $statusConfig['not_started'];

        return sprintf('
            <div class="text-center">
                <div class="mb-1">
                    <strong class="text-primary">Step: %s</strong>
                </div>
                <span class="badge %s">%s %s</span><br>
              
            </div>',
            $stepNumber,
            $statusInfo['class'],
            $statusInfo['icon'],
            $statusInfo['label']
        );
    }

    protected function getActionButtons($application): string
    {
        $buttons = '';

        // Check user access for the current step
        $accessType = $this->roleFilterService->getUserAccessTypeForCurrentStep($application);
        $canAccess = $this->roleFilterService->canUserAccessCurrentStep($application);
        $canSubmit = $this->roleFilterService->isUserSubmitterForCurrentStep($application);
        $canApprove = $this->roleFilterService->isUserApproverForCurrentStep($application);

        // Always show view button if user has access to the current step
        if ($canAccess) {
            $buttons .= '<button class="btn btn-success btn-sm" wire:click="view(' . $application->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
        }

        // Show edit button if user is submitter for the current step
        if ($canSubmit) {
            $buttons .= '<button class="btn btn-primary btn-sm" wire:click="edit(' . $application->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
        }

        // Show delete button if user has delete permission (only for superadmin or specific roles)
        if (can('ebps_map_applies delete') && isSuperAdmin()) {
            $buttons .= '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $application->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
        }

        // Show move forward button if user is approver for the current step
        if ($canApprove) {
            $buttons .= '<button type="button" class="btn btn-info btn-sm" wire:click="moveFurther(' . $application->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Move Forward"><i class="bx bx-right-arrow-alt"></i></button>&nbsp;';
        }

        return $buttons;
    }
    
    public function refresh(){}

    public function edit($id)
    {
        return redirect()->route('admin.ebps.building-registrations.edit',['id'=>$id]);
    }
    public function chooseOrganization($id)
    {
        $this->dispatch('open-choose-organization-modal', id: $id);
    }


    public function moveFurther($id)
    {
        return redirect()->route('admin.ebps.building-registrations.step', ['id'=>$id]);
    }

    public function view($id)
    {
        if(!can('ebps_map_applies access')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.ebps.building-registrations.view',['id'=>$id]);
    }


    public function delete($id)
    {
        if(!can('ebps_map_applies delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new MapApplyAdminService();
        $service->delete(MapApply::findOrFail($id));
        $this->successFlash(__('ebps::ebps.map_apply_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_map_applies delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
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
