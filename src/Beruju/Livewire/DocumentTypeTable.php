<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Beruju\Models\DocumentType;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Beruju\Service\DocumentTypeAdminService;
use Illuminate\Support\Str;

class DocumentTypeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = DocumentType::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline rounded-0"
            ])
            ->setAdditionalSelects(['id'])
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
        return DocumentType::query()
            ->with(['creator', 'updater'])
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        return [
            Column::make(__('beruju::beruju.id'), 'id')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.name_eng'), 'name_eng')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.name_nep'), 'name_nep')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.remarks'), 'remarks')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    return Str::limit($value, 50);
                }),

            Column::make(__('beruju::beruju.created_by'), 'created_by')
                ->sortable()
                ->format(function ($value, $row) {
                    if (!$row->creator) return __('beruju::beruju.system');
                    return $row->creator->name;
                }),

            Column::make(__('beruju::beruju.created_at'), 'created_at')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    return $value->format('M d, Y H:i');
                }),

            Column::make(__('beruju::beruju.actions'), 'id')
                ->format(function ($value) {
                    $actions = '';

                    if (can('beruju edit')) {
                        $actions .= '<button class="btn btn-sm me-1 rounded-0" onclick="editDocumentType(' . $value . ')" title="' . __('beruju::beruju.edit_document_type') . '">
                            <i class="bx bx-edit"></i>
                        </button>';
                    }

                    if (can('beruju delete')) {
                        $actions .= '<button class="btn btn-sm rounded-0" onclick="deleteDocumentType(' . $value . ')" title="' . __('beruju::beruju.delete_document_type') . '">
                            <i class="bx bx-trash"></i>
                        </button>';
                    }

                    return $actions;
                })
                ->html()
        ];
    }

    public function refresh()
    {
        // Refresh the table data
    }

    public function edit($id)
    {
        if (!can('beruju edit')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }

        $documentType = DocumentType::find($id);
        if (!$documentType) {
            SessionFlash::ERROR_FLASH(__('beruju::beruju.document_type_not_found'));
            return false;
        }

        return redirect()->route('admin.beruju.document-types.edit', $id);
    }

    #[On('delete-document-type')]
    public function delete($id)
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }

        $documentType = DocumentType::find($id);
        if (!$documentType) {
            SessionFlash::ERROR_FLASH(__('beruju::beruju.document_type_not_found'));
            return false;
        }

        // Check if it's system-defined
        if ($documentType->is_system_defined) {
            SessionFlash::ERROR_FLASH(__('beruju::beruju.cannot_delete_system_defined_document_type'));
            return false;
        }

        $service = new DocumentTypeAdminService();
        $service->delete($documentType);

        SessionFlash::SUCCESS_FLASH(__('beruju::beruju.document_type_deleted_successfully'));
        $this->dispatch('refresh-table');
    }

    public function deleteSelected(): void
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return;
        }
        $service = new DocumentTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
        SessionFlash::SUCCESS_FLASH(__('beruju::beruju.document_type_deleted_successfully'));
    }

    public function exportSelected(): void
    {
        $this->clearSelected();
        // TODO: implement export similar to ActionType if needed
    }
}
