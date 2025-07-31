<?php

namespace Src\Meetings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Meetings\Exports\MeetingsExport;
use Src\Meetings\Models\Meeting;
use Src\Meetings\Service\MeetingAdminService;

class MeetingTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Meeting::class;
    public array $bulkActions = [

        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('met_meetings.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects([
                'met_meetings.id',
                'met_meetings.fiscal_year_id',
                'met_meetings.committee_id',
                'met_meetings.meeting_id',
                'met_meetings.meeting_name',
                'met_meetings.recurrence',
                'met_meetings.start_date',
                'met_meetings.en_start_date',
                'met_meetings.end_date',
                'met_meetings.en_end_date',
                'met_meetings.recurrence_end_date',
                'met_meetings.en_recurrence_end_date',
                'met_meetings.description',
                'met_meetings.user_id',
                'met_meetings.is_print',
            ])
            ->setBulkActionsStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return Meeting::query()
            ->with([
                'fiscalYear',
                'committee',
                'meeting',
                'decisions',
                'committeeMembers',
                'agendas',
                'invitedMembers',
            ])
            ->orderBy('created_at', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Meeting"))->label(
                fn($row, Column $column) => view('Meetings::livewire.meeting-table.col-primary')->with([
                    'row' => $row
                ])->render()
            )->html(),
            Column::make(__("Date Time"))->label(
                fn($row, Column $column) => view('Meetings::livewire.meeting-table.col-datetime', [
                    'row' => $row,
                ])->render()
            )->html(),

            Column::make(__("Committee"))->label(
                fn($row, Column $column) => view('Meetings::livewire.meeting-table.col-committee-members', [
                    'row' => $row,
                ])->render()
            )->html(),

            Column::make(__("Agendas"))->label(
                fn($row, Column $column) => view('Meetings::livewire.meeting-table.col-agendas', [
                    'row' => $row->agendas,
                ])->render()
            )->html(),
        ];
        if (can('meeting_update') || can('meeting_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="d-flex gap-2 flex-wrap">';

                if (can('meeting_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>';
                    $buttons .= $edit;
                }

                if (can('meeting_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                $buttons .= '<a title="' . __("Manage") . '" href="' . route("admin.meetings.manage", ['id' => $row->id]) . '" class="btn btn-sm text-white" style="background: #8BC34A;"><i class="bx bx-cog"></i> </a>';

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('meeting_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.meetings.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('meeting_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MeetingAdminService();
        $service->delete(Meeting::findOrFail($id));
        $this->successFlash("Meeting Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('meeting_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MeetingAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MeetingsExport($records), 'meetings.xlsx');
    }
}
