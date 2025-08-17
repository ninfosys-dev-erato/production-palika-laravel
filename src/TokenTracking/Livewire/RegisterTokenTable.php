<?php

namespace Src\TokenTracking\Livewire;


use App\Facades\GlobalFacade;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Employees\Models\Branch;
use Src\TokenTracking\Enums\TokenPurposeEnum;
use Src\TokenTracking\Enums\TokenStageEnum;
use Src\TokenTracking\Enums\TokenStatusEnum;
use Src\TokenTracking\Exports\TokenTrackingExport;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Service\RegisterTokenAdminService;

class RegisterTokenTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = RegisterToken::class;

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
            ->setAdditionalSelects([
                'id',
                'token_purpose',
                'current_branch',
            ])
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
        $query = RegisterToken::query()
            ->with([
                'tokenHolder',
                'branches',
                'currentBranch',
                'tokenHolder',
                'logs',
            ])
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->select('entry_time', 'exit_time', 'estimated_time', 'stage')
            ->orderBy('created_at', 'DESC'); // Select some things

        $departmentId = GlobalFacade::department();

        if (!isSuperAdmin()) {
            if ($departmentId) {
                $query->where('current_branch', $departmentId);
            }
        }

        return $query;
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('tokentracking::tokentracking.token'), "token")->format(function ($value, $row) {
                return (string) view('TokenTracking::livewire.table.col-token-details-min', [
                    'token' => $row,
                ]);
            })
                ->html()
                ->collapseOnTablet()
                ->searchable(function (Builder $query, $searchTerm) {
                    $query->orWhere('token', 'like', '%' . $searchTerm . '%');
                }),
            Column::make(__("tokentracking::tokentracking.token_holder"), "token")->format(function ($value, $row) {
                return (string) view('TokenTracking::livewire.table.col-token-holder-details', [
                    'token' => $row,
                ]);
            })
                ->html()
                ->collapseOnTablet(),
            Column::make(__('tokentracking::tokentracking.time'))
                ->label(function ($row, Column $column) {
                    return (string) view('TokenTracking::livewire.table.date-time', [
                        'row' => $row,
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('tokentracking::tokentracking.stage'))
                ->label(function ($row, Column $column) {
                    if (can('tok_token action')) {
                        return (string) view('TokenTracking::livewire.table.status-stage-dropdown', [
                            'row' => $row,
                        ]);
                    }
                    return '';
                })
                ->html()
                ->collapseOnTablet(),

        ];
        if (can('tok_token action')) {
            $actionsColumn = Column::make(__('tokentracking::tokentracking.actions'))->label(function ($row, Column $column) {
                return (string) view('TokenTracking::livewire.table.col-register-token-actions', [
                    'row' => $row,
                ]);
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
        return redirect()->route('admin.register_tokens.edit', ['id' => $id]);
    }

    public function view($id)
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.register_tokens.view',  $id);
    }
    public function exitTime($id)
    {
        $exitTime = RegisterToken::findorfail($id);
        $exitTime->exit_time = now()->format('H:i');
        $exitTime->save();
        $this->successFlash(__('tokentracking::tokentracking.checkout_successfully'));
    }

    public function feedBack($id)
    {
        $this->dispatch('edit-tokenFeedback', $id);
    }
    public function delete($id)
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegisterTokenAdminService();
        $service->delete(RegisterToken::findOrFail($id));
        $this->successFlash(__('tokentracking::tokentracking.register_token_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('tok_token action')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegisterTokenAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokenTrackingExport($records), 'register_tokens.xlsx');
    }

    public function updateStatus(RegisterToken $registerToken, TokenStatusEnum $tokenStatusEnum)
    {
        $service = new RegisterTokenAdminService();
        if ($service->updateStatus($registerToken, $tokenStatusEnum)) {
            $this->successToast((__('tokentracking::tokentracking.status_updated_successfully')));
        } else {
            $this->errorToast((__('tokentracking::tokentracking.status_updated_failed')));
        }
    }

    public function updateStage(RegisterToken $registerToken, TokenStageEnum $tokenStageEnum)
    {
        $service = new RegisterTokenAdminService();
        if ($service->updateStage($registerToken, $tokenStageEnum)) {
            $this->successToast((__('tokentracking::tokentracking.stage_updated_successfully')));
        } else {
            $this->errorToast((__('tokentracking::tokentracking.stage_updated_failed')));
        }
    }

    public function updateBranch($id, $newBranch)
    {
        $service = new RegisterTokenAdminService();
        $service->updateBranch(RegisterToken::findOrFail($id), $newBranch);

        $this->successFlash(__('tokentracking::tokentracking.branch_updated_successfully'));
        $this->dispatch('close-branch-modal');
    }
}
