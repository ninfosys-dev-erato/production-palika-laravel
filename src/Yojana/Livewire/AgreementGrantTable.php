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
use Src\Yojana\Models\AgreementGrant;
use Src\Yojana\Service\AgreementGrantAdminService;

class AgreementGrantTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = AgreementGrant::class;
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
        return AgreementGrant::query()
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
            Column::make(__('yojana::yojana.agreement_id'), "agreement_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.source_type_id'), "source_type_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.material_name'), "material_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.unit'), "unit") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.amount'), "amount") ->sortable()->searchable()->collapseOnTablet(),
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
        return redirect()->route('admin.agreement_grants.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('plan delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new AgreementGrantAdminService();
        $service->delete(AgreementGrant::findOrFail($id));
        $this->successFlash(__('yojana::yojana.agreement_grant_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new AgreementGrantAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'agreement-grants.xlsx');
    }
}
