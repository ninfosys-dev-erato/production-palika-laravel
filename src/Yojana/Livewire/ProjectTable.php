<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectsExport;
use Src\Yojana\Models\Project;
use Src\Yojana\Service\ProjectAdminService;

class ProjectTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Project::class;
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
        return Project::query()
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
            Column::make("Registration No", "registration_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Fiscal Year Id", "fiscal_year_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Project Name", "project_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Plan Area Id", "plan_area_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Project Status", "project_status") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Project Start Date", "project_start_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Project Completion Date", "project_completion_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Plan Level Id", "plan_level_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Ward No", "ward_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Allocated Amount", "allocated_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Project Venue", "project_venue") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Evaluation Amount", "evaluation_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Purpose", "purpose") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Operated Through", "operated_through") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Progress Spent Amount", "progress_spent_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Physical Progress Target", "physical_progress_target") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Physical Progress Completed", "physical_progress_completed") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Physical Progress Unit", "physical_progress_unit") ->sortable()->searchable()->collapseOnTablet(),
Column::make("First Quarterly Amount", "first_quarterly_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("First Quarterly Goal", "first_quarterly_goal") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Second Quarterly Amount", "second_quarterly_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Second Quarterly Goal", "second_quarterly_goal") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Third Quarterly Amount", "third_quarterly_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Third Quarterly Goal", "third_quarterly_goal") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Agencies Grants", "agencies_grants") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Share Amount", "share_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Committee Share Amount", "committee_share_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Labor Amount", "labor_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Benefited Organization", "benefited_organization") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Others Benefited", "others_benefited") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Expense Head Id", "expense_head_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contingency Amount", "contingency_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Other Taxes", "other_taxes") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Is Contracted", "is_contracted") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Date", "contract_date") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('projects edit') || can('projects delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('projects edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('projects delete')) {
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
        if(!can('projects edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.projects.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('projects delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectAdminService();
        $service->delete(Project::findOrFail($id));
        $this->successFlash("Project Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('projects delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectsExport($records), 'projects.xlsx');
    }
}
