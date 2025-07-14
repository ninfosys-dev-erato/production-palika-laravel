<?php /** @noinspection ALL */

namespace Src\Yojana\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\Yojanailter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Yojana\Exports\ProjectInchargeExport;
use Src\Yojana\Models\ProjectIncharge;
use Src\Yojana\Service\ProjectInchargeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class ProjectInchargeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = ProjectIncharge::class;
    public $plan;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_project_incharge.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_project_incharge.id'])
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
        return ProjectIncharge::query()
            ->with('employee.designation')
            ->where('pln_project_incharge.plan_id','=',$this->plan->id)
            ->where('pln_project_incharge.deleted_at',null)
            ->where('pln_project_incharge.deleted_by',null)
           ->orderBy('pln_project_incharge.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__('yojana::yojana.employee'), "employee.name") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.designation'), "employee.designation.title") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.remarks'), "remarks") ->sortable()->searchable()->collapseOnTablet(),
         BooleanColumn::make(__('yojana::yojana.is_active'), "is_active") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_incharge edit') || can('project_incharge delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_incharge edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_incharge delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
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
        if(!can('project_incharge edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        $this->dispatch('edit-project-incharge', $id);

//        return redirect()->route('admin.project_incharge.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_incharge delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectInchargeAdminService();
        $service->delete(ProjectIncharge::findOrFail($id));
        $this->successFlash(__('yojana::yojana.project_incharge_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('project_incharge delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectInchargeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectInchargeExport($records), 'project_incharge.xlsx');
    }
}
