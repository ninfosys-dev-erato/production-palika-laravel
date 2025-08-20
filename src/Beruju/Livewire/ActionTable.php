<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Traits\WithSearch;
use Src\Beruju\Models\Action as BerujuAction;
use Src\Beruju\Service\ActionAdminService;
use Illuminate\Support\Str;

class ActionTable extends DataTableComponent
{
    use SessionFlash, WithSearch;

    protected $model = BerujuAction::class;
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
        return BerujuAction::query()
            ->with(['resolutionCycle', 'actionType', 'creator', 'updater'])
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('beruju::beruju.resolution_cycle'), "cycle_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->resolutionCycle ? 'Cycle #' . $row->resolutionCycle->id : 'N/A';
                }),
            Column::make(__('beruju::beruju.action_type'), "action_type_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->actionType ? $row->actionType->name_eng : 'N/A';
                }),
            Column::make(__('beruju::beruju.status'), "status")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    $statusColors = [
                        'Pending' => 'warning',
                        'Completed' => 'success',
                        'Rejected' => 'danger'
                    ];
                    $color = $statusColors[$value] ?? 'secondary';
                    return "<span class='badge bg-{$color}'>{$value}</span>";
                })->html(),

            Column::make(__('beruju::beruju.resolved_amount'), "resolved_amount")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $value ? number_format($value, 2) : 'N/A';
                }),

            Column::make(__('beruju::beruju.remarks'), "remarks")->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('beruju edit') || can('beruju delete')) {
            $actionsColumn = Column::make(__('beruju::beruju.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('beruju edit')) {
                    $edit = '<button class="btn btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('beruju delete')) {
                    $delete = '<button type="button" class="btn btn-sm" wire:confirm="' . __('beruju::beruju.confirm_delete') . '" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
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
        if (!can('beruju edit')) {
            $this->errorFlash(__('beruju::beruju.no_permission_to_edit'));
            return;
        }

        $this->dispatch('edit-action', $id);
    }

    public function delete($id)
    {
        if (!can('beruju delete')) {
            $this->errorFlash(__('beruju::beruju.no_permission_to_delete'));
            return;
        }

        try {
            $action = BerujuAction::findOrFail($id);
            $service = new ActionAdminService();
            $service->delete($action);
            $this->successFlash(__('beruju::beruju.action_deleted_successfully'));
            $this->dispatch('action-deleted');
        } catch (\Exception $e) {
            $this->errorFlash($e->getMessage());
        }
    }

    public function exportSelected()
    {
        // Implementation for export functionality
        $this->successFlash(__('beruju::beruju.export_functionality_not_implemented'));
    }

    public function deleteSelected()
    {
        if (!can('beruju delete')) {
            $this->errorFlash(__('beruju::beruju.no_permission_to_delete'));
            return;
        }

        try {
            $service = new ActionAdminService();
            $service->collectionDelete($this->selected);
            $this->successFlash(__('beruju::beruju.selected_actions_deleted_successfully'));
            $this->clearSelected();
            $this->dispatch('actions-deleted');
        } catch (\Exception $e) {
            $this->errorFlash($e->getMessage());
        }
    }
}
