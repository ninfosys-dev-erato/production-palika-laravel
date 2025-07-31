<?php

namespace Src\Meetings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Meetings\Exports\ParticipantsExport;
use Src\Meetings\Models\Participant;
use Src\Meetings\Service\ParticipantAdminService;

class ParticipantTable extends DataTableComponent
{
    use SessionFlash;

    public ?int $meetingId;

    protected $model = Participant::class;

    public function mount($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('met_participants.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_participants.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return Participant::query()
            ->where('met_participants.meeting_id', $this->meetingId)
            ->select(
                'met_participants.name', 
                'met_participants.email', 
                'met_participants.designation', 
                'met_participants.phone', 
                'met_participants.id'
            )
            ->orderBy('name', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            // Column::make(__("Meeting Name"), "meeting.meeting_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Committee Member Name"), "committeeMember.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Details"))->label(
                fn ($row, Column $column) => view('Meetings::livewire.participants-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__("Contacts"))->label(
                fn ($row, Column $column) => view('Meetings::livewire.participants-table.col-contact')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
        ];
        if (can('meeting_participants_update') || can('meeting_participants_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('meeting_participants_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('meeting_participants_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }
        return $columns;

    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('meeting_participants_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.participants.edit', ['meeting'=>$this->meetingId,'id' => $id]);
    }

    public function delete($id)
    {
        if (!can('meeting_participants_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ParticipantAdminService();
        $service->delete(Participant::findOrFail($id));
        $this->successFlash("Participant Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('meeting_participants_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ParticipantAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ParticipantsExport($records), 'participants.xlsx');
    }
}