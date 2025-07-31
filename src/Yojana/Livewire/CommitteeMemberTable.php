<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\CommitteeMembersExport;
use Src\Yojana\Models\CommitteeMember;
use Src\Yojana\Service\CommitteeMemberAdminService;

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
            Column::make(__('yojana::yojana.committee_name') , "committee.committee_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.details'))->label(
                fn ($row, Column $column) => view('Committees::livewire.committee-member-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('yojana::yojana.contacts'))->label(
                fn ($row, Column $column) => view('Committees::livewire.committee-member-table.col-contact')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            // Column::make(__('yojana::yojana.position'), "position")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('committee_member_update') || can('committee_member_delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('committee_member_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('committee_member_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
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
        $this->successFlash(__('yojana::yojana.committee_member_deleted_successfully'));
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
