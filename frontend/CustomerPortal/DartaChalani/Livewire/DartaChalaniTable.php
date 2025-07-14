<?php

namespace Frontend\CustomerPortal\DartaChalani\Livewire;


use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\FileTracking\Exports\FileRecordsExport;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\FileRecordAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class DartaChalaniTable extends DataTableComponent
{
    use SessionFlash,IsSearchable, HelperDate;
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
        // dd(Auth::guard('customer')->user()->mobile_no);
        return FileRecord::query()
            ->select('applicant_name', 'applicant_mobile_no', 'applicant_address', 'document_level', 'reg_no', 'title')
            ->where('deleted_at',null)
            ->where('subject_type',"Src\FileTracking\Models\FileRecord")
            ->where('applicant_mobile_no', Auth::guard('customer')->user()->mobile_no )
            ->where('deleted_by',null)
           ->orderBy('created_at','DESC');
    }
    public function filters(): array
    {
        return [
            SelectFilter::make(__('Document Level'))
            ->options([
                '' => 'All',
                'palika' => 'Palika',
                'ward' => 'Ward',
            ])
            ->filter(function (Builder $builder, string $value) {
                if ($value !== '') {
                    $builder->where('document_level', $value);
                }
            }),

        ];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__('Reg No'))
            ->label(function($row) {
                return $row->reg_no ? "#{$row->reg_no} | {$row->title}" : "{$row->title}";
            })
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('reg_no', 'like', "%{$term}%")
                            ->orWhere('title', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),
            Column::make(__("Applicant Details"), "applicant_mobile_no")
                ->label(function ($row) {
                    $applicant_name = $row->applicant_name ?? 'N/A';
                    $applicant_mobile_no= $row->applicant_mobile_no ?? 'N/A';
                    return "
                        <div>{$applicant_name} | {$applicant_mobile_no}</div>
                        
                    ";
                })
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('applicant_name', 'like', "%{$term}%")
                            ->orWhere('applicant_mobile_no', 'like', "%{$term}%");
                })
                ->html(),
            Column::make(__("Date"), "created_at")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    $bsDate = $this->adToBs($value, "yyyy-mm-dd");
                    return $this->convertEnglishToNepali($bsDate);
                }),          
           
     ];
        // if (can('darta_update') || can('darta_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                // if (can('darta_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                // }

                // if (can('darta_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;

                    $view = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $view;
                // }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        // }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('darta_update')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.register_files.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('darta_delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new FileRecordAdminService();
        $service->delete(FileRecord::findOrFail($id));
        $this->successFlash("File Record Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('darta_delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
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
