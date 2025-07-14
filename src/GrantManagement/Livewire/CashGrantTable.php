<?php

namespace Src\GrantManagement\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\GrantManagement\Exports\GrantManagementExport;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Service\CashGrantAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class CashGrantTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = CashGrant::class;
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
            ->setAdditionalSelects(['id', 'address', 'name', 'helplessness_type_id'])
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
        return CashGrant::query()
            ->with('ward', 'user', 'getHelplessnessType')
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
            Column::make(__('grantmanagement::grantmanagement.name'))->label(function ($row) {
                return $row->user?->name;
            }),
            Column::make(__('grantmanagement::grantmanagement.address'))
                ->label(function ($row) {
                    return $row->ward?->address_ne;
                })
                ->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.age'), "age")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.contact'), "contact")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.citizenship_no'), "citizenship_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.father_name'), "father_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.grandfather_name'), "grandfather_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.helplessness_type'))
                ->label(function ($row) {
                    return $row->getHelplessnessType?->helplessness_type;
                })
                ->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.cash'), "cash")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('cash_grants edit') || can('cash_grants delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('cash_grants edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('cash_grants view')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')"><i class="bx bx-show"></i></button>&nbsp;';

                    $buttons .= $view;
                }

                if (can('cash_grants delete')) {
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

    public function show($id)
    {
        if (!can('cash_grants view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.cash_grants.show', ['id' => $id]);
    }
    public function edit($id)
    {
        if (!can('cash_grants edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.cash_grants.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('cash_grants delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CashGrantAdminService();
        $service->delete(CashGrant::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.cash_grant_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('cash_grants delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CashGrantAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'cash-grants.xlsx');
    }
}
