<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ConfigurationsExport;
use Src\Yojana\Models\Configuration;
use Src\Yojana\Service\ConfigurationAdminService;

class ConfigurationTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Configuration::class;
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
        return Configuration::query()
            ->with('type')
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
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.amount'), "amount")->sortable()->searchable()->collapseOnTablet()
            ->format( fn ($value) => __('yojana::yojana.rs').replaceNumbersWithLocale($value, true)),
            Column::make(__('yojana::yojana.rate'), "rate")->sortable()->searchable()->collapseOnTablet()
            ->format( fn ($value) => replaceNumbersWithLocale($value, true).'%'),
            Column::make(__('yojana::yojana.type'), "type_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->type ? $row->type->title : "N/A";
                }),
        ];
        if (can('configurations edit') || can('configurations delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('configurations edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('configurations delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('configurations edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-configuration', configuration: $id);
        // return redirect()->route('admin.configurations.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('configurations delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ConfigurationAdminService();
        $service->delete(Configuration::findOrFail($id));
        $this->successFlash(__('yojana::yojana.configuration_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('configurations delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ConfigurationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ConfigurationsExport($records), 'configurations.xlsx');
    }
}
