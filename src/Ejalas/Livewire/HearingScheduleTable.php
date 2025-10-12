<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\HearingSchedulesExport;
use Src\Ejalas\Models\HearingSchedule;
use Src\Ejalas\Service\HearingScheduleAdminService;

class HearingScheduleTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = HearingSchedule::class;
    //for report
    public $report = false;
    public $from;
    public $startDate = null;
    public $endDate = null;
    public $selectedReconciliationCenter;

    protected $listeners = ['getSearchDate' => 'getSearchDate'];

    //---------------------------------->
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_hearing_schedules.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_hearing_schedules.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function mount($report = false, $from = null)  // Default to false if not passed
    {
        $this->report = $report;
        $this->from = $from;
    }
    public function getSearchDate($startDate, $endDate, $selectedReconciliationCenter)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedReconciliationCenter = $selectedReconciliationCenter;
    }

    public function builder(): Builder
    {
        return HearingSchedule::query()
            ->select('*')
            ->with(['complaintRegistration', 'fiscalYear', 'complaintRegistration.parties', 'complaintRegistration.disputeMatter'])
            ->where('jms_hearing_schedules.deleted_at', null)
            ->where('jms_hearing_schedules.deleted_by', null)
            ->orderBy('jms_hearing_schedules.created_at', 'DESC')
            ->when($this->report, function ($query) {
                $query->whereBetween('hearing_date', [$this->startDate, $this->endDate])
                    ->when($this->selectedReconciliationCenter, function ($query) {
                        $query->where('jms_hearing_schedules.reconciliation_center_id', $this->selectedReconciliationCenter);
                    });
            });
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [

            Column::make(__('ejalas::ejalas.case_details'))->label(function ($row) {
                $hearingPaperNo = $row->hearing_paper_no ?? "N/A";
                $referenceNo = $row->reference_no ?? "N/A";
                return "
                    <strong>" . (__('ejalas::ejalas.hearing_no')) . ":" . "</strong> {$hearingPaperNo} <br>
                    <strong>" . (__('ejalas::ejalas.ejalashreferenceno')) . ":" . "</strong> {$referenceNo}
                ";
            })->html()->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.hearing_schedule'))->label(function ($row) {
                // $hearingDate = $row->hearing_date ?? "N/A";
                $hearingDate = $row->hearing_date ? replaceNumbers($this->adToBs($row->hearing_date), true) : "N/A";
                $hearingTime = $row->hearing_time ?? "N/A";

                return "
                    <strong>" . (__('ejalas::ejalas.date')) . ":" . "</strong> {$hearingDate} <br>
                    <strong>" . (__('ejalas::ejalas.time')) . ":" . "</strong> {$hearingTime}
                ";
            })->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.defender'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Defender')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),
            Column::make(__('ejalas::ejalas.complainer'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Complainer')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),

            Column::make(__('ejalas::ejalas.subject'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 100px;' title='{$row->complaintRegistration->disputeMatter->title}'>
                                {$row->complaintRegistration->disputeMatter->title}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

        ];
        if (!$this->report && (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print'))) {
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
        return redirect()->route('admin.ejalas.hearing_schedules.edit', ['id' => $id, 'from' => $this->from]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new HearingScheduleAdminService();
        $service->delete(HearingSchedule::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.hearing_schedule_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new HearingScheduleAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new HearingSchedulesExport($records), 'hearing_schedules.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.hearing_schedules.preview', ['id' => $id]);
    }
}
