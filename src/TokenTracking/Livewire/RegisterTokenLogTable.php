<?php

namespace Src\TokenTracking\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\TokenTracking\Exports\TokenTrackingExport;
use Src\TokenTracking\Models\RegisterTokenLog;
use Src\TokenTracking\Service\RegisterTokenLogAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSortable;

class RegisterTokenLogTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = RegisterTokenLog::class;
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
        return RegisterTokenLog::query()
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
            Column::make(__('tokentracking::tokentracking.token_id'), "token_id"),
            Column::make(__('tokentracking::tokentracking.old_branch'), "old_branch")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.current_branch'), "current_branch")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.old_stage'), "old_stage")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.current_stage'), "current_stage")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.old_status'), "old_status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.current_status'), "current_status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.old_values'), "old_values")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.current_values'), "current_values")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.description'), "description")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('tok_token action')) {
            $actionsColumn = Column::make(__('tokentracking::tokentracking.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('tok_token action')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('tok_token action')) {
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
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH(__('tokentracking::tokentracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.register_token_logs.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegisterTokenLogAdminService();
        $service->delete(RegisterTokenLog::findOrFail($id));
        $this->successFlash(__('tokentracking::tokentracking.register_token_log_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegisterTokenLogAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokenTrackingExport($records), 'register-token-logs.xlsx');
    }
}
