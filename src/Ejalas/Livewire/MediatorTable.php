<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\MediatorsExport;
use Src\Ejalas\Models\Mediator;
use Src\Ejalas\Service\MediatorAdminService;

class MediatorTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Mediator::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_mediators.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_mediators.id'])
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
        return Mediator::query()
            ->select(
                'listed_no',
                'mediator_name',
                'mediator_address',
                'ward_id',
                'training_detail',
                'mediator_phone_no',
                'mediator_email',
                'municipal_approval_date',
            )
            ->with('fiscalYear', 'ward')
            ->where('jms_mediators.deleted_at', null)
            ->where('jms_mediators.deleted_by', null)
            ->orderBy('jms_mediators.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.listed_no'))
                ->label(function ($row) {
                    return "
                        <strong>" . (__('ejalas::ejalas.listed_no')) . ":" . "</strong> " . ($row->listed_no ?? "N/A");
                })
                ->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.mediator_detail'))
                ->label(function ($row) {
                    return "<strong>" . (__('ejalas::ejalas.name')) . ":" . "</strong> " . ($row->mediator_name ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.address')) . ":" . "</strong> " . ($row->mediator_address ?? "N/A") .
                        "<br> <strong>" . (__('ejalas::ejalas.phone')) . ":" . "</strong> " . ($row->mediator_phone_no ?? "N/A") . "<br>
                <strong>" . (__('ejalas::ejalas.email')) . ":" . "</strong> " . ($row->mediator_email ?? "N/A");
                })
                ->html()->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.ward_no'), "ward.ward_name_en")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.training_detail'), "training_detail")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.municipal_approval_date'), "municipal_approval_date")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_settings edit') || can('jms_settings delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_settings delete')) {
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
        if (!can('jms_settings edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-mediator', $id);
        // return redirect()->route('admin.ejalas.mediators.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MediatorAdminService();
        $service->delete(Mediator::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.mediator_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new MediatorAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new MediatorsExport($records), 'mediators.xlsx');
    }
}
