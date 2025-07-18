<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\JudicialMembersExport;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Service\JudicialMemberAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class JudicialMemberTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = JudicialMember::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
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
        return JudicialMember::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.ejalashjudicialmembername'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ejalashjudicialcommitteeposition'), "member_position")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.elected_position'), "elected_position")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('ejalas::ejalas.active'), "status")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('judicial_members edit') || can('judicial_members delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('judicial_members edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('judicial_members delete')) {
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
        if (!can('judicial_members edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-judicial-members', $id);

        // return redirect()->route('admin.ejalas.judicial_members.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('judicial_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialMemberAdminService();
        $service->delete(JudicialMember::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.judicial_member_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('judicial_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialMemberAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new JudicialMembersExport($records), 'judicial_members.xlsx');
    }
}
