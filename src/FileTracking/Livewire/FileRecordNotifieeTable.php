<?php

namespace Src\FileTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\FileTracking\Exports\FileRecordNotifieesExport;
use Src\FileTracking\Models\FileRecordNotifiee;
use Src\FileTracking\Service\FileRecordNotifieeAdminService;

class FileRecordNotifieeTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = FileRecordNotifiee::class;
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
        return FileRecordNotifiee::query()
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
            Column::make(__('filetracking::filetracking.record_log_number'), "file_record_log_id") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('filetracking::filetracking.notifiable_type'), "notifiable_type") 
            ->sortable()
            ->searchable()
            ->collapseOnTablet()
            ->format(function ($value) {
                return class_basename($value);
            }),
            Column::make(__('filetracking::filetracking.notifiable'), "notifiable_id")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value, $column) {
                    $notifiableType = $column->getModel()->notifiable_type;
                    if (class_exists($notifiableType)) {
                        $handler = $notifiableType::find($value); 
                        if ($handler) {
                            return "Name: {$handler->name}<br>Email: " . ($handler->email ?? 'N/A') . "<br>Phone No: " . ($handler->mobile_no ?? 'N/A');
                        }
                    }
                    return "N/A";
                })
                ->html(),
     ];
        if (can('file_record_notifiees edit') || can('file_record_notifiees delete')) {
            $actionsColumn = Column::make(__('filetracking::filetracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('file_record_notifiees edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('file_record_notifiees delete')) {
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
        if(!can('file_record_notifiees edit')){
               SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.file_record_notifiees.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('file_record_notifiees delete')){
                SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new FileRecordNotifieeAdminService();
        $service->delete(FileRecordNotifiee::findOrFail($id));
        $this->successFlash( __('filetracking::filetracking.file_record_notifiee_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('file_record_notifiees delete')){
                    SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new FileRecordNotifieeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FileRecordNotifieesExport($records), 'file_record_notifiees.xlsx');
    }
}
