<?php

namespace Src\Meetings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Meetings\Exports\InvitedMembersExport;
use Src\Meetings\Models\InvitedMember;
use Src\Meetings\Service\InvitedMemberAdminService;

class InvitedMemberTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    public ?int $meetingId;
    protected $model = InvitedMember::class;

    public function mount($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('met_invited_members.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_invited_members.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');

    }

    public function builder(): Builder
    {
        return InvitedMember::query()
            ->where('met_invited_members.meeting_id', $this->meetingId)
            ->select('name', 'designation', 'phone', 'email')
            ->orderBy('name', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Meeting Name"), "meeting.meeting_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Details"))->label(
                fn ($row, Column $column) => view('Meetings::livewire.invited-member-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__("Contacts"))->label(
                fn ($row, Column $column) => view('Meetings::livewire.invited-member-table.col-contact')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
        ];
        if (can('meeting_invited_member_update') || can('meeting_invited_member_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('meeting_invited_member_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('meeting_invited_member_delete')) {
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
        if (!can('meeting_invited_member_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.invited-members.edit', ['meeting'=>$this->meetingId,'id' => $id]);
    }

    public function delete($id)
    {
        if (!can('meeting_invited_member_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new InvitedMemberAdminService();
        $service->delete(InvitedMember::findOrFail($id));
        $this->successFlash("Invited Member Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('meeting_invited_member_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new InvitedMemberAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new InvitedMembersExport($records), 'invited_members.xlsx');
    }
}