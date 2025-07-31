<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Exports\RegistrationIndicatorsExport;
use Src\Ejalas\Models\RegistrationIndicator;
use Src\Ejalas\Service\RegistrationIndicatorAdminService;

class RegistrationIndicatorTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = RegistrationIndicator::class;
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
        return RegistrationIndicator::query()
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
            Column::make(__('ejalas::ejalas.dispute_matter'), "dispute_title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.indicator_type'), "indicator_type")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    return PartyType::from($value)->label();
                }),
        ];
        if (can('registration_indicators edit') || can('registration_indicators delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('registration_indicators edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('registration_indicators delete')) {
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
        if (!can('registration_indicators edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return $this->dispatch('edit-registration-indicator', $id);
        // return redirect()->route('admin.ejalas.registration_indicators.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('registration_indicators delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationIndicatorAdminService();
        $service->delete(RegistrationIndicator::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.registration_indicator_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('registration_indicators delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationIndicatorAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new RegistrationIndicatorsExport($records), 'registration_indicators.xlsx');
    }
}
