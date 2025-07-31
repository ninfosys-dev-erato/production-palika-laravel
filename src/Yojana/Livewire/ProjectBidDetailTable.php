<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectBidDetailsExport;
use Src\Yojana\Models\ProjectBidDetail;
use Src\Yojana\Service\ProjectBidDetailAdminService;

class ProjectBidDetailTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectBidDetail::class;
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
        return ProjectBidDetail::query()
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
            Column::make("Project Id", "project_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Cost Estimation", "cost_estimation") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Notice Published Date", "notice_published_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Newspaper Name", "newspaper_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Evaluation Decision Date", "contract_evaluation_decision_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Intent Notice Publish Date", "intent_notice_publish_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Newspaper Name", "contract_newspaper_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Acceptance Decision Date", "contract_acceptance_decision_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Percentage", "contract_percentage") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contractor Name", "contractor_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contractor Address", "contractor_address") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contractor Phone", "contractor_phone") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Confession Number", "confession_number") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Agreement Date", "contract_agreement_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Contract Assigned Date", "contract_assigned_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid Bond Amount", "bid_bond_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid Bond No", "bid_bond_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid Bond Bank Name", "bid_bond_bank_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid Bond Issue Date", "bid_bond_issue_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid Bond Expiry Date", "bid_bond_expiry_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond No", "performance_bond_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond Amount", "performance_bond_amount") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond Bank", "performance_bond_bank") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond Issue Date", "performance_bond_issue_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond Expiry Date", "performance_bond_expiry_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Performance Bond Extended Date", "performance_bond_extended_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Insurance Issue Date", "insurance_issue_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Insurance Expiry Date", "insurance_expiry_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Insurance Extended Date", "insurance_extended_date") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Bid No", "bid_no") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_bid_details edit') || can('project_bid_details delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('project_bid_details edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_bid_details delete')) {
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
        if(!can('project_bid_details edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_bid_details.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_bid_details delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectBidDetailAdminService();
        $service->delete(ProjectBidDetail::findOrFail($id));
        $this->successFlash("Project Bid Detail Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('project_bid_details delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectBidDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectBidDetailsExport($records), 'project_bid_details.xlsx');
    }
}
