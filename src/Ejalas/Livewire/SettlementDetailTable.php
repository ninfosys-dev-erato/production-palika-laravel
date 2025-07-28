<?php

namespace Src\Ejalas\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\SettlementDetailsExport;
use Src\Ejalas\Models\SettlementDetail;
use Src\Ejalas\Service\SettlementDetailAdminService;

class SettlementDetailTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = SettlementDetail::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('jms_settlement_details.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_settlement_details.id'])
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
        return SettlementDetail::query()
            ->select('*')
            ->with(['party'])
            ->whereNull('jms_settlement_details.deleted_at')
            ->whereNull('jms_settlement_details.deleted_by')
            ->orderBy('jms_settlement_details.created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            // Column::make(__('ejalas::ejalas.complaint_registration_id'), "complaintRegistration.reg_no")
            //     ->sortable()
            //     ->searchable()
            //     ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.party'), "party.name")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.deadline_set_date'), "deadline_set_date")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.detail'), "detail")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];

        if (can('jms_judicial_management edit') || can('jms_judicial_management delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')"><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
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
        if (!can('jms_judicial_management edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.settlement_details.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new SettlementDetailAdminService();
        $service->delete(SettlementDetail::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.settlement_detail_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new SettlementDetailAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new SettlementDetailsExport($records), 'settlement_details.xlsx');
    }
}
