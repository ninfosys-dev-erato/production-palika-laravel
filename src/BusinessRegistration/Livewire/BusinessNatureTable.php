<?php

namespace Src\BusinessRegistration\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\BusinessRegistration\Models\NatureOfBusiness;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Service\NatureOfBusinessAdminService;
use Src\BusinessRegistration\Service\RegistrationCategoryAdminService;

class BusinessNatureTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = NatureOfBusiness::class;

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
        return NatureOfBusiness::query()
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
            Column::make(__('businessregistration::businessregistration.title'), "title")->sortable()->searchable()->collapseOnTablet(),

        ];
        if (can('business_natures edit') || can('business_natures delete')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('business_natures edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
                if (can('business_natures delete')) {
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
        if (!can('business_natures edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-businessnature', businessNature: $id);
        // return redirect()->route('admin.business-registration.business-nature.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('business_natures delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new NatureOfBusinessAdminService();
        $service->delete(NatureOfBusiness::findOrFail($id));

        $this->successFlash("Business Nature Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('business_natures delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new NatureOfBusinessAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
}
