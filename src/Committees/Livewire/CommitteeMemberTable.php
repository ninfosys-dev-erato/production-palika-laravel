<?php

namespace Src\Committees\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Committees\Exports\CommitteeMembersExport;
use Src\Committees\Models\CommitteeMember;
use Src\Committees\Service\CommitteeMemberAdminService;

class CommitteeMemberTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = CommitteeMember::class;

    public function configure(): void
    {
        $this->setPrimaryKey('met_committee_members.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_committee_members.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return CommitteeMember::query()
            ->select('name', 'email', 'designation', 'phone')
            ->orderBy('met_committee_members.position');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('Committee Name') , "committee.committee_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Details"))->label(
                fn ($row, Column $column) => view('Committees::livewire.committee-member-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__("Contacts"))->label(
                fn ($row, Column $column) => view('Committees::livewire.committee-member-table.col-contact')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            // Column::make(__("Position"), "position")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('committee_member_update') || can('committee_member_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('committee_member_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('committee_member_delete')) {
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
        if (!can('committee_member_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.committee-members.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('committee_member_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CommitteeMemberAdminService();
        $service->delete(CommitteeMember::findOrFail($id));
        $this->successFlash(__("Committee Member Deleted Successfully"));
    }

    public function deleteSelected()
    {
        if (!can('committee_member_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CommitteeMemberAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CommitteeMembersExport($records), 'committee_members.xlsx');
    }
}
