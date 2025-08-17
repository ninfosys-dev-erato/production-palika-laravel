<?php

namespace Src\Downloads\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Downloads\Exports\DownloadsExport;
use Src\Downloads\Models\Download;
use Src\Downloads\Service\DownloadAdminService;

class DownloadTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Download::class;
    public array $bulkActions = [

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
        return Download::query()
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
         Column::make(__('downloads::downloads.title'), 'title') ->sortable()->searchable()->collapseOnTablet(),
         Column::make(__('downloads::downloads.title_en'), 'title_en') ->sortable()->searchable()->collapseOnTablet(),
// Column::make(__('downloads::downloads.order'), 'order') ->sortable()->searchable()->collapseOnTablet(),
         Column::make(__('downloads::downloads.status'), 'status') ->sortable()->searchable()->collapseOnTablet()
             ->format(function($value, $row) {
                $isActive = $row->status == 1;
                return view('livewire-tables.includes.columns.status_switch', [
                    'rowId' => $row->id,
                    'isActive' => $isActive
                ]);
            })
            ->collapseOnTablet(),
        ];
        if (can('downloads edit') || can('downloads delete')) {
            $actionsColumn = Column::make(__('downloads::downloads.works'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('downloads edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('downloads delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }

    public function toggleStatus($id)
    {
        $download = Download::findOrFail($id);
        $download->status = !$download->status;
        $download->save();

        $this->successFlash(__('downloads::downloads.status_updated_successfully'));
    }

    public function refresh(){}
    public function edit($id)
    {
        if(!can('downloads edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.downloads.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('downloads delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new DownloadAdminService();
        $service->delete(Download::findOrFail($id));
        $this->successFlash(__('downloads::downloads.download_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('downloads delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new DownloadAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DownloadsExport($records), 'downloads.xlsx');
    }
}
