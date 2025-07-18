<?php

namespace Src\FuelSettings\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\FuelSettings\Exports\FuelSettingsExport;
use Src\FuelSettings\Models\FuelSetting;
use Src\FuelSettings\Service\FuelSettingAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class FuelSettingTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = FuelSetting::class;
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
        return FuelSetting::query()
            ->with(['acceptor', 'reviewer'])
            // ->where('deleted_at', null)
            // ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__("Acceptor Id"), "acceptor_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->acceptor ? $row->acceptor->name : "N/A";
                }),
            Column::make(__("Reviewer Id"), "reviewer_id")->sortable()->searchable()->collapseOnTablet()->format(function ($value, $row, $column) {
                return $row->reviewer ? $row->reviewer->name : "N/A";
            }),
            Column::make(__("Expiry Days"), "expiry_days")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Ward No", "ward_no")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('fuel_settings edit') || can('fuel_settings delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('fuel_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('fuel_settings delete')) {
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
        if (!can('fuel_settings edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.fuel_settings.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('fuel_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FuelSettingAdminService();
        $service->delete(FuelSetting::findOrFail($id));
        $this->successFlash("Fuel Setting Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('fuel_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FuelSettingAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FuelSettingsExport($records), 'fuel_settings.xlsx');
    }
}
