<?php

namespace Src\Ejalas\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\FormTypesExport;
use Src\Ejalas\Models\FormType;
use Src\Ejalas\Service\FormTypeAdminService;
use Src\Ejalas\Enum\FormTypeEnum;

class FormTypeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = FormType::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('jms_form_types.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_form_types.id'])
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
        return FormType::query()
        ->with('form')
            ->select('*')
            ->where('jms_form_types.deleted_at', null)
            ->where('jms_form_types.deleted_by', null)
            ->orderBy('jms_form_types.created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.form_type_name'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.form_id'), "form.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.form_type'), "form_type")
            ->label(function ($row) {
                return $row->form_type
                    ? FormTypeEnum::from($row->form_type)->label()
                    : '';
            })
            ->sortable()
            ->searchable()
            ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.status'), 'status')
                ->label(function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    $label = $row->status ? 'Active' : 'Inactive';
                    return <<<HTML
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" $checked wire:click="toggleStatus({$row->id})">
                  
                        </div>
                    HTML;
                })
                ->html()
                ->collapseOnTablet(),
        ];

        if (can('jms_settings edit') || can('jms_settings delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('jms_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_settings delete')) {
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
        if (!can('jms_settings edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-form-type', formType: $id);
    }

    public function delete($id)
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FormTypeAdminService();
        $service->delete(FormType::findOrFail($id));
        $this->successFlash("Form Type Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('jms_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FormTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FormTypesExport($records), 'form-types.xlsx');
    }

    public function toggleStatus($id)
    {
        $formType = FormType::findOrFail($id);
        $formType->status = !$formType->status;
        $formType->save();

        $this->successFlash("Status updated successfully.");
    }
}
