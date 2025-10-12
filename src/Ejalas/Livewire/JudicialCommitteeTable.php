<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\JudicialCommitteesExport;
use Src\Ejalas\Models\JudicialCommittee;
use Src\Ejalas\Service\JudicialCommitteeAdminService;

class JudicialCommitteeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = JudicialCommittee::class;
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
        return JudicialCommittee::query()
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
            Column::make(__('ejalas::ejalas.judicialcommittee'), "committees_title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.judicialcommittee_surname'), "short_title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.subtitle'), "subtitle")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.judicialcommittee_committeeformationdate'), "formation_date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.phone_no'), "phone_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.email'), "email")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_settings edit') || can('jms_settings delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_settings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('jms_settings edit')) {
            $this->warningFlash(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }

        return $this->dispatch('edit-judicial-committee', $id);
        // return redirect()->route('admin.judicial_committees.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_settings delete')) {
            $this->warningFlash('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialCommitteeAdminService();
        $service->delete(JudicialCommittee::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.judicial_committee_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialCommitteeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new JudicialCommitteesExport($records), 'judicial_committees.xlsx');
    }
}
