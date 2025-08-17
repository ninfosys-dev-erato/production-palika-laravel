<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\PlanAreasExport;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Service\PlanAreaAdminService;

class PlanAreaTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = PlanArea::class;
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
        return PlanArea::query()
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
            Column::make(__('yojana::yojana.area_name'), "area_name")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan_basic_settings edit') || can('plan_basic_settings delete')) {
            $actionsColumn = Column::make(__(__('yojana::yojana.actions')))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('plan_basic_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')"  ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_basic_settings delete')) {
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
        if (!can('plan_basic_settings edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');

            return false;
        }
        $this->dispatch('edit-plan-area', planArea: $id);
        //        return redirect()->route('admin.plan_areas.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAreaAdminService();
        $service->delete(PlanArea::findOrFail($id));
        $this->successToast(__('yojana::yojana.plan_area_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PlanAreaAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PlanAreasExport($records), 'plan_areas.xlsx');
    }
}
