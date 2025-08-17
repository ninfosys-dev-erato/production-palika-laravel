<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\MediatorSelectionsExport;
use Src\Ejalas\Models\MediatorSelection;
use Src\Ejalas\Service\MediatorSelectionAdminService;

class MediatorSelectionTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = MediatorSelection::class;
    public $from;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_mediator_selections.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_mediator_selections.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function mount($from = null)  // Default to false if not passed
    {
        $this->from = $from;
    }
    public function builder(): Builder
    {
        return MediatorSelection::query()
            ->with(['complaintRegistration', 'mediator'])
            ->where('jms_mediator_selections.deleted_at', null)
            ->where('jms_mediator_selections.deleted_by', null)
            ->orderBy('jms_mediator_selections.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.mediator_name'), "mediator.mediator_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.mediator_type'), "mediator_type")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.mediator_selection_date'), "selection_date")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm me-1" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
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
        if (!can('jms_judicial_management edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.mediator_selections.edit', ['id' => $id, 'from' => $this->from,]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MediatorSelectionAdminService();
        $service->delete(MediatorSelection::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.mediator_selection_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MediatorSelectionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MediatorSelectionsExport($records), 'mediator_selections.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.mediator_selections.preview', ['id' => $id]);
    }
}
