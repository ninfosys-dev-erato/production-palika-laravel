<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\BenefitedMemberDetailsExport;
use Src\Yojana\Models\BenefitedMemberDetail;
use Src\Yojana\Service\BenefitedMemberDetailAdminService;

class BenefitedMemberDetailTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = BenefitedMemberDetail::class;
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
        return BenefitedMemberDetail::query()
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
Column::make("Ward No", "ward_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Village", "village") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Dalit Backward No", "dalit_backward_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Other Households No", "other_households_no") ->sortable()->searchable()->collapseOnTablet(),
Column::make("No Of Male", "no_of_male") ->sortable()->searchable()->collapseOnTablet(),
Column::make("No Of Female", "no_of_female") ->sortable()->searchable()->collapseOnTablet(),
Column::make("No Of Others", "no_of_others") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('benefited_member_details edit') || can('benefited_member_details delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('benefited_member_details edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('benefited_member_details delete')) {
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
        if(!can('benefited_member_details edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.benefited_member_details.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('benefited_member_details delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new BenefitedMemberDetailAdminService();
        $service->delete(BenefitedMemberDetail::findOrFail($id));
        $this->successFlash("Benefited Member Detail Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('benefited_member_details delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new BenefitedMemberDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BenefitedMemberDetailsExport($records), 'benefited_member_details.xlsx');
    }
}
