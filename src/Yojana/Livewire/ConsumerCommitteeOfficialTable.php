<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ConsumerCommitteeOfficialsExport;
use Src\Yojana\Models\ConsumerCommitteeOfficial;
use Src\Yojana\Service\ConsumerCommitteeOfficialAdminService;

class ConsumerCommitteeOfficialTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ConsumerCommitteeOfficial::class;
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
        return ConsumerCommitteeOfficial::query()
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
            Column::make("Consumer Committee Id", "consumer_committee_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Post", "post") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Name", "name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Father Name", "father_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Grandfather Name", "grandfather_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Address", "address") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Gender", "gender") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Phone", "phone") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Citizenship No", "citizenship_no") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('consumer_committee_officials edit') || can('consumer_committee_officials delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('consumer_committee_officials edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('consumer_committee_officials delete')) {
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
        if(!can('consumer_committee_officials edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.consumer_committee_officials.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('consumer_committee_officials delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ConsumerCommitteeOfficialAdminService();
        $service->delete(ConsumerCommitteeOfficial::findOrFail($id));
        $this->successFlash("Consumer Committee Official Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('consumer_committee_officials delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ConsumerCommitteeOfficialAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ConsumerCommitteeOfficialsExport($records), 'consumer_committee_officials.xlsx');
    }
}
