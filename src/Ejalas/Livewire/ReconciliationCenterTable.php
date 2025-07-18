<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\ReconciliationCentersExport;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\ReconciliationCenterAdminService;

class ReconciliationCenterTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = ReconciliationCenter::class;
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
        return ReconciliationCenter::query()
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
            Column::make(__('ejalas::ejalas.ejalasheconciliationcentername'), "reconciliation_center_title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.surname'), "surname")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.subtile'), "subtile")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ward_no'), "ward_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.established_date'), "established_date")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('reconciliation_centers edit') || can('reconciliation_centers delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('reconciliation_centers edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('reconciliation_centers delete')) {
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
        if (!can('reconciliation_centers edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        // return redirect()->route('admin.ejalas.reconciliation_centers.edit', ['id' => $id]);
        return $this->dispatch('edit-reconciliation-center', $id);
    }
    public function delete($id)
    {
        if (!can('reconciliation_centers delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ReconciliationCenterAdminService();
        $service->delete(ReconciliationCenter::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.reconciliation_center_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('reconciliation_centers delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ReconciliationCenterAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ReconciliationCentersExport($records), 'reconciliation_centers.xlsx');
    }
}
