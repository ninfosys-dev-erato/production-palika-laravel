<?php

namespace Src\Yojana\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Yojana\Exports\YojanaExport;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanExtensionRecord;
use Src\Yojana\Service\PlanExtensionRecordAdminService;

class PlanExtensionRecordTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = PlanExtensionRecord::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public Plan $plan;

    public function monut(Plan $plan)
    {
        $this->plan = $plan->load('agreement');
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_plan_extension_records.*'])
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
        return PlanExtensionRecord::query()
            ->where('plan_id', $this->plan->id)
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
        Column::make(__('yojana::yojana.planextensionrecordextension_date'), "extension_date") ->sortable()->searchable()->collapseOnTablet(),
        Column::make(__('yojana::yojana.planextensionrecordletter_submission_date'), "letter_submission_date") ->sortable()->searchable()->collapseOnTablet(),
         Column::make(__('yojana::yojana.planextensionrecordprevious_extension_date'))
             ->label(fn($row) => $row->previous_extension_date ?? '-')
             ->collapseOnTablet(),

         Column::make(__('yojana::yojana.planextensionrecordprevious_completion_date'))
             ->label(fn($row) => $row->previous_submission_date ?? $this->plan?->agreement?->plan_completion_date ?? '-')
             ->collapseOnTablet(),
        Column::make(__('yojana::yojana.planextensionrecordletter'), "letter") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('plan edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan delete')) {
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
        if(!can('plan edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        $this->dispatch('load-plan-extension', $id);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new PlanExtensionRecordAdminService();
        $service->delete(PlanExtensionRecord::findOrFail($id));
        $this->successFlash(__('yojana::yojana.plan_extension_record_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new PlanExtensionRecordAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'plan-extension-records.xlsx');
    }
}
