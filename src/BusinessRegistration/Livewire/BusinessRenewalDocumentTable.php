<?php

namespace Src\BusinessRegistration\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\BusinessRegistration\Exports\BusinessRenewalDocumentsExport;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;
use Src\BusinessRegistration\Service\BusinessRenewalDocumentAdminService;

class BusinessRenewalDocumentTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = BusinessRenewalDocument::class;
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
        return BusinessRenewalDocument::query()
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
            Column::make(__('businessregistration::businessregistration.business_registration_id'), "business_registration_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.business_renewal'), "business_renewal") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.document_name'), "document_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.document'), "document") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.document_details'), "document_details") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.document_status'), "document_status") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('businessregistration::businessregistration.comment_log'), "comment_log") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('business_renewals edit') || can('business_renewals delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('business_renewals edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('business_renewals delete')) {
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
        if(!can('business_renewals edit')){
               SessionFlash::WARNING_FLASH(__('businessregistration::businessregistration.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.business_renewal_documents.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('business_renewals delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new BusinessRenewalDocumentAdminService();
        $service->delete(BusinessRenewalDocument::findOrFail($id));
        $this->successFlash(__('businessregistration::businessregistration.business_renewal_document_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('business_renewals delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new BusinessRenewalDocumentAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BusinessRenewalDocumentsExport($records), 'business_renewal_documents.xlsx');
    }
}
