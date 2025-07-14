<?php

namespace Src\FiscalYears\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\FiscalYears\Exports\FiscalYearsExport;
use Src\FiscalYears\Models\FiscalYear;
use Src\FiscalYears\Service\FiscalYearAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FiscalYearTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = FiscalYear::class;
    public array $bulkActions = [

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
//            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        return FiscalYear::query()
            ->orderBy('year','desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('fiscalyears::fiscalyears.year'), "year")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('fiscal_year_update') || can('fiscal_year_delete')) {
            $actionsColumn = Column::make(__('fiscalyears::fiscalyears.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('fiscal_year_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('fiscal_year_delete')) {
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
        if (!can('fiscal_year_update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.setting.fiscal-years.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('fiscal_year_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FiscalYearAdminService();
        $service->delete(FiscalYear::findOrFail($id));
        $this->successFlash("Fiscal Year Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('fiscal_year_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FiscalYearAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected(): BinaryFileResponse
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FiscalYearsExport($records), 'fiscal_years.xlsx');
    }
}
