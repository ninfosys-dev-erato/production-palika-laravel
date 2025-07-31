<?php

namespace Src\Ejalas\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ejalas\Exports\DisputeAreasExport;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Service\DisputeAreaAdminService;

class DisputeAreaTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = DisputeArea::class;
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
        return DisputeArea::query()
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
            Column::make(__('ejalas::ejalas.ejalashdisputeareatitle'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ejalashdisputeareatitleen'), "title_en")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('dispute_areas edit') || can('dispute_areas delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('dispute_areas edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('dispute_areas delete')) {
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
        if (!can('dispute_areas edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        // return redirect()->route('admin.ejalas.dispute_areas.edit', ['id' => $id]);
        return $this->dispatch('edit-dispute-area', $id);
    }
    public function delete($id)
    {
        if (!can('dispute_areas delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeAreaAdminService();
        $service->delete(DisputeArea::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.dispute_area_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('dispute_areas delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeAreaAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DisputeAreasExport($records), 'dispute_areas.xlsx');
    }
}
