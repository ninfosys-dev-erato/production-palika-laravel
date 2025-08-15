<?php

namespace Src\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Exports\BuildingConstructionTypesExport;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Service\AdditionalFormService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ebps\Models\AdditionalForm;

class AdditionalFormSettingTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = AdditionalForm::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('ebps_additional_forms.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['ebps_additional_forms.id'])
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
        return AdditionalForm::with('form')
            ->where('ebps_additional_forms.deleted_at', null)
            ->where('ebps_additional_forms.deleted_by', null)
            ->orderBy('ebps_additional_forms.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ebps::ebps.name'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ebps::ebps.form'), "form.title")->sortable()->searchable()->collapseOnTablet(),


            Column::make(__('ebps::ebps.status'), 'status')
                ->label(function ($row) {
                    $checked = $row->status ? 'checked' : '';

                    return <<<HTML
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" $checked wire:click="toggleStatus({$row->id})">
                     
                    </div>
                HTML;
                })
                ->html()
                ->collapseOnTablet(),
        ];
        if (can('ebps_settings edit') || can('ebps_settings delete')) {
            $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('ebps_settings delete')) {
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
        if (!can('ebps_settings edit')) {
            SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-additional-form-setting', $id);
        // return redirect()->route('admin.ebps.building_construction_types.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if (!can('ebps_settings delete')) {
            SessionFlash::WARNING_FLASH(__('ebps::ebps.you_cannot_perform_this_action'));
            return false;
        }
        $service = new AdditionalFormService();
        $service->delete(AdditionalForm::findOrFail($id));
        $this->successFlash(__('ebps::ebps.additional_form_deleted_successfully'));
    }


    public function toggleStatus($id)
    {
        $additionform = AdditionalForm::findOrFail($id);
        $additionform->status = !$additionform->status;
        $additionform->save();

        $this->successFlash("Status updated successfully.");
    }
}
