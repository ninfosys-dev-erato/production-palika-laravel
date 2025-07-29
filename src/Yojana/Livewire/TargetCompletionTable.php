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
use Src\Yojana\Models\TargetCompletion;
use Src\Yojana\Service\TargetCompletionAdminService;
use Illuminate\Contracts\View\View;
class TargetCompletionTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = TargetCompletion::class;
    public $plan;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function mount($plan){
        $this->plan = $plan;
    }
    public function configure(): void
    {
        $this->setPrimaryKey('pln_target_completion.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_target_completion.id'])
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
        return TargetCompletion::with('targetEntry.processIndicator')
            ->where('pln_target_completion.plan_id',$this->plan->id)
            ->where('pln_target_completion.deleted_at',null)
            ->where('pln_target_completion.deleted_by',null)
            ->orderBy('pln_target_completion.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.progress_indicator'), "targetEntry.processIndicator.title")
                ->sortable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.unit'), "targetEntry.processIndicator.unit.symbol")
                ->sortable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.physical_completed_goals'), "completed_physical_goal")
                ->sortable()->collapseOnTablet()
                ->format(fn ($value) => replaceNumbersWithLocale($value, true)),

            Column::make(__('yojana::yojana.financial_completed_goals'), "completed_financial_goal")
                ->sortable()->collapseOnTablet()
                ->format(fn ($value) => replaceNumbersWithLocale($value, true)),

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
        $this->dispatch('load-target-completion', $id);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TargetCompletionAdminService();
        $service->delete(TargetCompletion::findOrFail($id));
        $this->successFlash(__('yojana::yojana.target_completion_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TargetCompletionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TargetEntriesExport($records), 'target_completions.xlsx');
    }

}
