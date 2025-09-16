<?php

namespace Src\Yojana\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Yojana\Exports\YojanaExport;
use Src\Yojana\Models\Agreement;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\AgreementAdminService;

class AgreementTable extends DataTableComponent
{
    use SessionFlash, LivewireAlert;
    protected $model = Agreement::class;
    public $plan;
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

    public function mount($plan = null)
    {
        if ($plan) {
            $this->plan = $plan;
        }
    }
    public function builder(): Builder
    {
        return Agreement::with('implementationMethod')
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
        Column::make(__('yojana::yojana.plan_start_date'), "plan_start_date")
            ->sortable()->searchable()->collapseOnTablet(),
         Column::make(__('yojana::yojana.plan_completion_date'), "plan_completion_date")
            ->sortable()->searchable()->collapseOnTablet(),
         Column::make(__('yojana::yojana.implementation_method'), "implementation_method_id")
            ->format(fn($value, $row, Column $column) => $row?->implementationMethod?->title)
            ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan edit') || can('plan delete')) {
            $actionsColumn = Column::make(__(__('yojana::yojana.actions')))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan settings')) {
                    $settings = '<button class="btn btn-info btn-sm" wire:click="print(' . $row->id . ')" ><i class="bx bx-printer"></i></button>&nbsp;';
                    $buttons .= $settings;
                }
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
//        return redirect()->route('admin.agreements.edit',['id'=>$id]);
        $this->dispatch('loadAgreement', $id);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new AgreementAdminService();
        $service->delete(Agreement::findOrFail($id));
        $this->successFlash(__('yojana::yojana.agreement_deleted_successfully'));
    }

    public function print($id){
        $service = new AgreementAdminService();
        $agreementContent = $service->printAgreement($id);
        if (!isset($agreementContent)){
            $this->errorFlash('Agreement Format Not Found');
        }
        // $this->dispatch('open-pdf-in-new-tab', url: $agreementFormat);
        $this->dispatch('print-agreement', html: $agreementContent);
        // return $agreementFormat;
    }

    public function deleteSelected(){
        if(!can('plan delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new AgreementAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'agreements.xlsx');
    }
}
