<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\DisputeRegistrationCourtsExport;
use Src\Ejalas\Models\DisputeRegistrationCourt;
use Src\Ejalas\Service\DisputeRegistrationCourtAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class DisputeRegistrationCourtTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = DisputeRegistrationCourt::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_dispute_registration_courts.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_dispute_registration_courts.id'])
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
        return DisputeRegistrationCourt::query()
            ->select('*')
            ->with(['complaintRegistration', 'judicialEmployee'])
            ->where('jms_dispute_registration_courts.deleted_at', null)
            ->where('jms_dispute_registration_courts.deleted_by', null)
            ->orderBy('jms_dispute_registration_courts.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_registration_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.registrar'), "judicialEmployee.name")->sortable()->searchable()->collapseOnTablet(),
            // BooleanColumn::make(__('ejalas::ejalas.details_provided'), "is_details_provided")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.dispute_status'), "status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.status_date'), "decision_date")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm ms-1" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
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
        return redirect()->route('admin.ejalas.dispute_registration_courts.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeRegistrationCourtAdminService();
        $service->delete(DisputeRegistrationCourt::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.dispute_registration_court_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeRegistrationCourtAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DisputeRegistrationCourtsExport($records), 'dispute_registration_courts.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.dispute_registration_courts.preview', ['id' => $id]);
    }
}
