<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\LegalDocumentsExport;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Service\LegalDocumentAdminService;

//this table is used inside the form of legal document to filter out data accorrding to complaint registration
class LegalDocumentDependentTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = LegalDocument::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public $ComplaintRegId;
    protected $listeners = ['refreshLegalDocumentDependentTable' => 'refreshTable'];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_legal_documents.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_legal_documents.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return LegalDocument::query()
            ->select('*')
            ->with(['party', 'complaintRegistration'])
            ->where('complaint_registration_id', $this->ComplaintRegId) // Filter by complaint_registration_id
            ->whereNull('jms_legal_documents.deleted_at')
            ->whereNull('jms_legal_documents.deleted_by')
            ->orderBy('jms_legal_documents.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_registration_id'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.party_name'), "party.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.document_writer_name'), "document_writer_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.document_date'), "document_date")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.document_details'), "document_details")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('legal_documents edit') || can('legal_documents delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('legal_documents edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('legal_documents delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('legal_documents edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.legal_documents.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('legal_documents delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LegalDocumentAdminService();
        $service->delete(LegalDocument::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.legal_document_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('legal_documents delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LegalDocumentAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new LegalDocumentsExport($records), 'legal_documents.xlsx');
    }
    public function refreshTable($complaintRegistrationId)
    {
        $this->ComplaintRegId = $complaintRegistrationId;
        $this->resetPage();
    }
}
