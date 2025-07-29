<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\CourtSubmissionsExport;
use Src\Ejalas\Models\CourtSubmission;
use Src\Ejalas\Service\CourtSubmissionAdminService;

class CourtSubmissionTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = CourtSubmission::class;

    public $report = false;
    public $startDate = null;
    public $endDate = null;
    protected $listeners = ['getSearchDate' => 'getSearchDate'];
    public function mount($report = false)  // Default to false if not passed
    {
        $this->report = $report;
    }
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_court_submissions.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_court_submissions.id'])
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
        return CourtSubmission::query()
            ->select('*')
            ->with(['complaintRegistration', 'judicialMember'])
            ->where('jms_court_submissions.deleted_at', null)
            ->where('jms_court_submissions.deleted_by', null)
            ->orderBy('jms_court_submissions.created_at', 'DESC')
            ->when($this->report, function ($query) {
                $query->whereBetween('discussion_date', [$this->startDate, $this->endDate]);
            });
    }
    public function getSearchDate($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.discussion_date'), "discussion_date")
                ->label(function ($row) {
                    return $row->discussion_date
                        ? replaceNumbers($this->adToBs($row->discussion_date), true)
                        : 'N/A';
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.submission_decision_date'), "submission_decision_date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.decision_authority'), "judicialMember.title")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (!$this->report && (can('jms_judicial_management edit') || can('jms_judicial_management delete'))) {
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

                $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                $buttons .= $preview;

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
        return redirect()->route('admin.ejalas.court_submissions.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CourtSubmissionAdminService();
        $service->delete(CourtSubmission::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.court_submission_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CourtSubmissionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CourtSubmissionsExport($records), 'court_submissions.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.court_submissions.preview', ['id' => $id]);
    }
}
