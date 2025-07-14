<?php

namespace Src\FileTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\FileTracking\Exports\FileRecordsExport;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\FileRecordAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class FileRecordTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = FileRecord::class;
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
        return FileRecord::query()
            ->select('applicant_name', 'applicant_mobile_no')
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
            Column::make(__('filetracking::filetracking.registration_number'), "reg_no") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('filetracking::filetracking.subject_type'), "subject_type")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    return class_basename($value);
                }),
          
            Column::make(__('filetracking::filetracking.subject'), "subject_id")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->html(),     


            Column::make(__('filetracking::filetracking.applicant_details'), "applicant_mobile_no")
                ->label(function ($row) {
                    $applicant_name = $row->applicant_name;
                    $applicant_mobile_no= $row->applicant_mobile_no;
                    return "
                        <div>{$applicant_name}</div>
                        <div>{$applicant_mobile_no}</div>
                    ";
                })
                ->sortable()
                ->searchable()
                ->html(),
     ];
        if (can('file_records edit') || can('file_records delete')) {
            $actionsColumn = Column::make(__('filetracking::filetracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                        $buttons .= $view;

                if (can('file_records edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('file_records delete')) {
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
        if(!can('file_records edit')){
               SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.file_records.edit',['id'=>$id]);
    }

    public function view($id)
    {
        if (!can('file_records view')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.file_records.show',  $id);
    }

    public function delete($id)
    {
        if(!can('file_records delete')){
                SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
                return false;
        }
        $service = new FileRecordAdminService();
        $service->delete(FileRecord::findOrFail($id));
        $this->successFlash( __('filetracking::filetracking.file_record_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('file_records delete')){
                    SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new FileRecordAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FileRecordsExport($records), 'file_records.xlsx');
    }
}
