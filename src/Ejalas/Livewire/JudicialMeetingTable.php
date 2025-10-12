<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\JudicialMeetingsExport;
use Src\Ejalas\Models\JudicialMeeting;
use Src\Ejalas\Service\JudicialMeetingAdminService;

class JudicialMeetingTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = JudicialMeeting::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_judicial_meetings.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_judicial_meetings.id'])
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
        return JudicialMeeting::query()
            ->select('*')
            ->with(['members', 'fiscalYear'])
            ->where('jms_judicial_meetings.deleted_at', null)
            ->where('jms_judicial_meetings.deleted_by', null)
            ->orderBy('jms_judicial_meetings.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [

            Column::make(__('ejalas::ejalas.meeting_date'))->label(function ($row) {
                $fiscalYear = $row->fiscalYear->year;
                $meetingDate = $row->meeting_date;
                $meetingTime = $row->meeting_time;
                return "
    <strong>" . (__('ejalas::ejalas.fiscal_year')) . ":" . "</strong> {$fiscalYear} <br>
    <strong>" . (__('ejalas::ejalas.meeting_date')) . ":" . "</strong> {$meetingDate} <br>
    <strong>" . (__('ejalas::ejalas.meeting_time')) . ":" . "</strong> {$meetingTime}
";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.meeting_details'))->label(function ($row) {
                $meetingNumber = $row->meeting_number;
                $decisionNumber = $row->decision_number;
                return "
                  <strong>" . (__('ejalas::ejalas.meeting_number')) . ":" . "</strong> {$meetingNumber} <br>
                  <strong>" . (__('ejalas::ejalas.decision_number')) . ":" . "</strong> {$decisionNumber} 
                    ";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            // Column::make(__('ejalas::ejalas.invited_employee'))->label(function ($row) {
            //     
            //     $invited = $row->members->filter(function ($member) {
            //         return $member->pivot->type == 'invited';
            //     });
            //     $invitedList = implode(', ', $invited->pluck('title')->toArray());

            //     return "<span style='max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' title='{$invitedList}'>{$invitedList}</span>";
            // })->html()
            //     ->sortable()
            //     ->searchable()
            //     ->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.members_present'))->label(function ($row) {
            //     
            //     $present = $row->members->filter(function ($member) {
            //         return $member->pivot->type == 'present';
            //     });
            //     $presentList = implode(', ', $present->pluck('title')->toArray());
            //     return "<span style='max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' title='{$presentList}'>{$presentList}</span>";
            // })->html()
            //     ->sortable()
            //     ->searchable()
            //     ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.meeting_topic'))->label(function ($row) {
                $meetingTopic = $row->meeting_topic;
                return "<span style='max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' title='{$meetingTopic}'>{$meetingTopic}</span>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            // Column::make(__('ejalas::ejalas.decision_details'), "decision_details")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print')) {
            $actionsColumn = Column::make(__(__('ejalas::ejalas.actions')))->label(function ($row, Column $column) {
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
                    $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
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
        return redirect()->route('admin.ejalas.judicial_meetings.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialMeetingAdminService();
        $service->delete(JudicialMeeting::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.judicial_meeting_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialMeetingAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new JudicialMeetingsExport($records), 'judicial_meetings.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.judicial_meetings.preview', ['id' => $id]);
    }
}
