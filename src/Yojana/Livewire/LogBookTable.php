<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\LogBooksExport;
use Src\Yojana\Models\LogBook;
use Src\Yojana\Service\LogBookAdminService;

class LogBookTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = LogBook::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_log_book.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_log_book.id'])
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
        return LogBook::query()
            ->where('pln_log_book.deleted_at',null)
            ->where('pln_log_book.deleted_by',null)
           ->orderBy('pln_log_book.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make(__('yojana::yojana.employee'), "employee.name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.date'), "date") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.visit_time'), "visit_time") ->sortable()->searchable()->collapseOnTablet()
    ->format(function ($value, $row, Column $column) {
        return $value ? Carbon::createFromFormat('H:i', $value)->format('g:i A') : null;
    }),
Column::make(__('yojana::yojana.return_time'), "return_time") ->sortable()->searchable()->collapseOnTablet()
    ->format(function ($value, $row, Column $column) {
        return $value ? Carbon::createFromFormat('H:i', $value)->format('g:i A') : null;
    }),
Column::make(__('yojana::yojana.visit_type'), "visit_type") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.visit_purpose'), "visit_purpose") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.description'), "description") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan_log_books edit') || can('plan_log_books delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan_log_books edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_log_books delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
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
        if(!can('plan_log_books edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.log_books.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('plan_log_books delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new LogBookAdminService();
        $service->delete(LogBook::findOrFail($id));
        $this->successFlash(__('yojana::yojana.log_book_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan_log_books delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new LogBookAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new LogBooksExport($records), 'log_books.xlsx');
    }
}
