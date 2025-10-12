<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\DisputeMattersExport;
use Src\Ejalas\Models\DisputeMatter;
use Src\Ejalas\Service\DisputeMatterAdminService;

class DisputeMatterTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = DisputeMatter::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_dispute_matters.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_dispute_matters.id'])
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
        return DisputeMatter::query()
            ->with('disputeArea')
            ->where('jms_dispute_matters.deleted_at', null)
            ->where('jms_dispute_matters.deleted_by', null)
            ->orderBy('jms_dispute_matters.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.ejalashdisputemattertitle'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.dispute_area'), "disputeArea.title_en")->sortable()->searchable()->collapseOnTablet(),
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
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }

        $this->dispatch('edit-dispute-matter', $id);
        // $this->dispatch('reset-form');

        // return redirect()->route('admin.ejalas.dispute_matters.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeMatterAdminService();
        $service->delete(DisputeMatter::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.dispute_matter_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeMatterAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DisputeMattersExport($records), 'dispute_matters.xlsx');
    }
}
