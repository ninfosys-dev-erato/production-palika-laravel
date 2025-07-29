<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\WitnessesRepresentativesExport;
use Src\Ejalas\Models\WitnessesRepresentative;
use Src\Ejalas\Service\WitnessesRepresentativeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class WitnessesRepresentativeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = WitnessesRepresentative::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_witnesses_representatives.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_witnesses_representatives.id'])
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
        return WitnessesRepresentative::query()
            ->with('complaintRegistration')
            ->where('jms_witnesses_representatives.deleted_at', null)
            ->where('jms_witnesses_representatives.deleted_by', null)
            ->orderBy('jms_witnesses_representatives.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.witness_name'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.witness_address'), "address")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('ejalas::ejalas.is_first_party'), "is_first_party")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                $preview = '<button type="button" class="btn btn-info btn-sm me-1" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                $buttons .= $preview;


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
        return redirect()->route('admin.ejalas.witnesses_representatives.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WitnessesRepresentativeAdminService();
        $service->delete(WitnessesRepresentative::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.witnesses_representative_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WitnessesRepresentativeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new WitnessesRepresentativesExport($records), 'witnesses_representatives.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.witnesses_representatives.preview', ['id' => $id]);
    }
}
