<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\TargetEntriesExport;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\TargetEntry;
use Src\Yojana\Service\TargetEntryAdminService;
use Illuminate\Contracts\View\View;
class TargetEntryTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = TargetEntry::class;
    public $plan;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function mount($plan){
        $this->plan  =$plan;
    }
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
        return TargetEntry::with('processIndicator','processIndicator.unit')
            ->where('plan_id',$this->plan->id)
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
            Column::make(__('yojana::yojana.progress_indicator_id'), "progress_indicator_id")
               ->sortable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.progress_indicator_id'), "progress_indicator_id")
               ->sortable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.progress_indicator_id'), "progress_indicator_id")
             ->footer(function($rows) {
                 return __('yojana::yojana.total');
             })->sortable()->collapseOnTablet(),
         Column::make(__('yojana::yojana.total_physical_progress'), "total_physical_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('total_physical_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.total_financial_progress'), "total_financial_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('total_financial_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.last_year_physical_progress'), "last_year_physical_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('last_year_physical_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.last_year_financial_progress'), "last_year_financial_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('last_year_financial_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.total_physical_goals'), "total_physical_goals")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('total_physical_goals') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.total_financial_goals'), "total_financial_goals")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('total_financial_goals') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.first_quarter_physical_progress'), "first_quarter_physical_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('first_quarter_physical_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.first_quarter_financial_progress'), "first_quarter_financial_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('first_quarter_financial_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.second_quarter_physical_progress'), "second_quarter_physical_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('second_quarter_physical_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.second_quarter_financial_progress'), "second_quarter_financial_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('second_quarter_financial_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.third_quarter_physical_progress'), "third_quarter_physical_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('third_quarter_physical_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),

         Column::make(__('yojana::yojana.third_quarter_financial_progress'), "third_quarter_financial_progress")
             ->format(fn($value) => replaceNumbersWithLocale($value ?? 0, true))
             ->footer(fn($rows) => replaceNumbersWithLocale($rows->sum('third_quarter_financial_progress') ?? 0, true))
             ->sortable()->collapseOnTablet(),
     ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan delete')) {
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
        if(!can('plan edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        $this->dispatch('load-target-entry', $id);
//        return redirect()->route('admin.target_entries.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new TargetEntryAdminService();
        $service->delete(TargetEntry::findOrFail($id));
        $this->successFlash(__('yojana::yojana.target_entry_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new TargetEntryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TargetEntriesExport($records), 'target_entries.xlsx');
    }

    public function render(): View
    {
        return view('Yojana::livewire.target-entry.table');
    }
}
