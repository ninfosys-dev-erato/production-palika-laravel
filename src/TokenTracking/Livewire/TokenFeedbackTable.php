<?php

namespace Src\TokenTracking\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\TokenTracking\Enums\CitizenSatisfactionEnum;
use Src\TokenTracking\Enums\ServiceAccesibilityEnum;
use Src\TokenTracking\Enums\ServiceQualityEnum;
use Src\TokenTracking\Exports\TokenFeedbacksExport;
use Src\TokenTracking\Models\TokenFeedback;
use Src\TokenTracking\Service\TokenFeedbackAdminService;

class TokenFeedbackTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = TokenFeedback::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('token_id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects([
                'token_id as id',
                'token_id',
                'service_quality',
                'service_accesibility',
                'citizen_satisfaction',
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
        return TokenFeedback::query()
            ->with(['token'])
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
            Column::make(__('tokentracking::tokentracking.token'))->label(
                fn($row, Column $column) => view('TokenTracking::livewire.table.col-token-details')->with([
                    'token' => $row->token->load([
                        'branches',
                        'currentBranch',
                        'tokenHolder',
                    ]),
                ])->render()
            )->html(),
            Column::make(__('tokentracking::tokentracking.service_quality'), "service_quality")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    // return __($row->service_quality);
                    return ServiceQualityEnum::from($value)->label();
                }),

            Column::make(__('tokentracking::tokentracking.service_accessibility'), "service_accesibility")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    // return __($row->service_accesibility);
                    return ServiceAccesibilityEnum::from($value)->label();
                }),

            Column::make(__('tokentracking::tokentracking.citizen_satisfaction'), "citizen_satisfaction")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    // return __($row->citizen_satisfaction);
                    return CitizenSatisfactionEnum::from($value)->label();
                }),

        ];

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('register_tokens edit')) {
            SessionFlash::WARNING_FLASH(__('tokentracking::tokentracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.token_feedbacks.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('register_tokens delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenFeedbackAdminService();
        $service->delete(TokenFeedback::findOrFail($id));
        $this->successFlash(__('tokentracking::tokentracking.token_feedback_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('register_tokens delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenFeedbackAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokenFeedbacksExport($records), 'token_feedbacks.xlsx');
    }
}
