<?php

namespace Src\Committees\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Committees\Exports\CommitteeTypesExport;
use Src\Committees\Models\CommitteeType;
use Src\Committees\Service\CommitteeTypeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class CommitteeTypeTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = CommitteeType::class;
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setPerPageAccepted([10, 25, 50, 100,500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }
    public function builder(): Builder
    {
        return CommitteeType::query()
            ->where('deleted_at',null)
            ->where('deleted_by',null)
           ->orderBy('created_at','DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__("Name"), "name") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Committee No"), "committee_no") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('committee_type_update') || can('committee_type_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('committee_type_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('committee_type_delete')) {
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
        if(!can('committee_type_update')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.committee-types.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('committee_type_delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new CommitteeTypeAdminService();
        $service->delete(CommitteeType::findOrFail($id));
        $this->successFlash("Committee Type Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('committee_type_delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new CommitteeTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CommitteeTypesExport($records), 'committee_types.xlsx');
    }
}
