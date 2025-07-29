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
use Src\GrantManagement\Models\GrantDetail;
use Src\GrantManagement\Service\GrantDetailAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class GrantDetailTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = GrantDetail::class;
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
        return GrantDetail::query()
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
            Column::make(__('grantmanagement::grantmanagement.grant_id'), "grant_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.grant_for'), "grant_for")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.model_type'), "model_type")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.model_id'), "model_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.personal_investment'), "personal_investment")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.is_old'), "is_old")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.prev_fiscal_year_id'), "prev_fiscal_year_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.investment_amount'), "investment_amount")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.remarks'), "remarks")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.local_body_id'), "local_body_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.ward_no'), "ward_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.village'), "village")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.tole'), "tole")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.plot_no'), "plot_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.contact_person'), "contact_person")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.contact'), "contact")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.user_id'), "user_id")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('gms_activity edit') || can('gms_activity delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('gms_activity edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('gms_activity delete')) {
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
        if (!can('gms_activity edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.grant_details.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrantDetailAdminService();
        $service->delete(GrantDetail::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.grant_detail_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrantDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'grant-details.xlsx');
    }
}
