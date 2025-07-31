<?php

namespace Src\BusinessRegistration\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\BusinessRegistration\Exports\RegistrationCategoryExport;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Service\RegistrationCategoryAdminService;

class RegistrationCategoryTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = RegistrationCategory::class;

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
        return RegistrationCategory::query()
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
            Column::make(__('businessregistration::businessregistration.registration_category'), "title")->sortable()->searchable()->collapseOnTablet(),

        ];
        if (can('business_category edit') || can('business_category edit')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('business_category edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('business_category delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }
                return $buttons."</div>";

            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('business_category edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-registrationCategory', registrationCategory: $id);
        // return redirect()->route('admin.business-registration.registration-category.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('business_category delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationCategoryAdminService();
        $service->delete(RegistrationCategory::findOrFail($id));
        $this->successFlash("Registration Type Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('business_category delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RegistrationCategoryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new RegistrationCategoryExport($records), 'registration-types.xlsx');
    }
}
