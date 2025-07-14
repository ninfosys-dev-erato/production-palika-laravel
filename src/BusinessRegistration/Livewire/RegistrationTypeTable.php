<?php

namespace Src\BusinessRegistration\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\BusinessRegistration\Exports\RegistrationTypeExport;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Service\RegistrationTypeAdminService;
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;

class RegistrationTypeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = RegistrationType::class;

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
        return RegistrationType::query()
            ->select('*')
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
            Column::make(__('businessregistration::businessregistration.business_registration_type'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('businessregistration::businessregistration.business_type'), "action")->sortable()->searchable()->collapseOnTablet(),
            // Add registration_category_enum column with enum label
            Column::make(__('businessregistration::businessregistration.registration_category_enum'), "registration_category_enum")
                ->label(function ($row) {
                    return $row->registration_category_enum
                        ? RegistrationCategoryEnum::from($row->registration_category_enum)->label()
                        : '';
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

        ];
        if (can('registration-type_update') || can('registration-type_delete')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('registration-type_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('registration-type_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }
                return $buttons . "</div>";
            })->html();
            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('registration-type_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-registrationtype', registrationType: $id);
        // return redirect()->route('admin.business-registration.registration-types.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('registration-type_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationTypeAdminService();
        $service->delete(RegistrationType::findOrFail($id));
        $this->successFlash("Registration Type Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('registration-type_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new RegistrationTypeExport($records), 'registration-types.xlsx');
    }
}
