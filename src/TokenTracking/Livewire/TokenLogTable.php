<?php

namespace Src\TokenTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\TokenTracking\Exports\TokenLogsExport;
use Src\TokenTracking\Models\TokenLog;
use Src\TokenTracking\Service\TokenLogAdminService;

class TokenLogTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = TokenLog::class;
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
        return TokenLog::query()
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
            Column::make(__('tokentracking::tokentracking.token_id'), "token_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.old_status'), "old_status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.new_status'), "new_status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.status'), "status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.stage_status'), "stage_status")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.old_branch'), "old_branch")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.new_branch'), "new_branch")->sortable()->searchable()->collapseOnTablet(),
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
        return redirect()->route('admin.token_logs.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenLogAdminService();
        $service->delete(TokenLog::findOrFail($id));
        $this->successFlash(__('tokentracking::tokentracking.token_log_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenLogAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokenLogsExport($records), 'token_logs.xlsx');
    }
}
