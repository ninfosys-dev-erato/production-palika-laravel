<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\CaseRecordsExport;
use Src\Ejalas\Models\CaseRecord;
use Src\Ejalas\Service\CaseRecordAdminService;

class CaseRecordTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = CaseRecord::class;

    protected $listeners = ['getSearchDate' => 'getSearchDate'];

    public $report = false;
    public $startDate = null;
    public $endDate = null;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_case_records.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_case_records.id'])
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
        return CaseRecord::query()
            ->select('*')
            ->with(['complaintRegistration', 'judicialMember', 'judicialEmployee'])
            ->where('jms_case_records.deleted_at', null)
            ->where('jms_case_records.deleted_by', null)
            ->orderBy('jms_case_records.created_at', 'DESC')
            ->when($this->report, function ($query) {
                $query->whereBetween('decision_date', [$this->startDate, $this->endDate]);
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
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.dates'))->label(function ($row) {
                return "<strong>" . (__('ejalas::ejalas.discussion_date')) . ":" . "</strong> {$row->discussion_date} <br>
                        <strong>" . (__('ejalas::ejalas.decision_date')) . ":" . "</strong>" . replaceNumbers($this->adToBs($row->decision_date), true);
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.decision_authority'), "judicialMember.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.recording_officer'))->label(function ($row) {
                return "<strong>" . (__('ejalas::ejalas.name')) . ":" . "</strong> {$row->judicialEmployee->name} <br>
                        <strong>" . (__('ejalas::ejalas.position')) . ":" . "</strong> {$row->recording_officer_position}";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.case_remark'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 200px;' title='{$row->remarks}'>
                                    {$row->remarks}
                                </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),



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
        return redirect()->route('admin.ejalas.case_records.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CaseRecordAdminService();
        $service->delete(CaseRecord::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.case_record_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CaseRecordAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CaseRecordsExport($records), 'case_records.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.case_records.preview', ['id' => $id]);
    }
}
