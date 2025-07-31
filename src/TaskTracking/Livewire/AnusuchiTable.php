<?php

namespace Src\TaskTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\TaskTracking\Exports\AnusuchisExport;
use Src\TaskTracking\Models\Anusuchi;
use Src\TaskTracking\Service\AnusuchiAdminService;

class AnusuchiTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Anusuchi::class;
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
        return Anusuchi::query()
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
            Column::make(__('tasktracking::tasktracking.name'), "name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.name_en'), "name_en") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('tasktracking::tasktracking.description'), "description") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('anusuchis edit') || can('anusuchis delete')) {
            $actionsColumn = Column::make(__('tasktracking::tasktracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('anusuchis edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('anusuchis delete')) {
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
        if(!can('anusuchis edit')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.anusuchis.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('anusuchis delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new AnusuchiAdminService();
        $service->delete(Anusuchi::findOrFail($id));
        $this->successFlash(__('tasktracking::tasktracking.anusuchi_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('anusuchis delete')){
            $this->warningFlash(__('tasktracking::tasktracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new AnusuchiAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new AnusuchisExport($records), 'anusuchis.xlsx');
    }
}
