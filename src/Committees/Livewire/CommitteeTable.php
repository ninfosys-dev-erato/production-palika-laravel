<?php

namespace Src\Committees\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Committees\Exports\CommitteesExport;
use Src\Committees\Models\Committee;
use Src\Committees\Service\CommitteeAdminService;

class CommitteeTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Committee::class;

    public function configure(): void
    {
        $this->setPrimaryKey('met_committees.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_committees.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return Committee::query()
            ->orderBy('met_committees.created_at','desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Committee Type"), "committeeType.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Committee Name"), "committee_name")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('committee_update') || can('committee_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('committee_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('committee_delete')) {
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
        if (!can('committee_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.committees.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('committee_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CommitteeAdminService();
        $service->delete(Committee::findOrFail($id));
        $this->successFlash("Committee Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('committee_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CommitteeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CommitteesExport($records), 'committees.xlsx');
    }
}
