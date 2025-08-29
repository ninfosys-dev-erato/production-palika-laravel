<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Beruju\Models\SubCategory;
use Src\Beruju\Service\SubCategoryAdminService;
use Illuminate\Support\Str;

class SubCategoryTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = SubCategory::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline rounded-0"
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
        return SubCategory::query()
            ->with(['parent', 'children', 'creator', 'updater'])
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
            Column::make(__('beruju::beruju.name_eng'), "name_eng")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('beruju::beruju.name_nep'), "name_nep")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('beruju::beruju.slug'), "slug")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('beruju::beruju.parent_category'), "parent_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->parent ? $row->parent->name_eng : __('beruju::beruju.root_category');
                }),
            Column::make(__('beruju::beruju.child_categories'), "id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    $count = $row->children()->count();
                    return $count > 0 ? $count : '0';
                }),
            Column::make(__('beruju::beruju.remarks'), "remarks")->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('beruju edit') || can('beruju delete')) {
            $actionsColumn = Column::make(__('beruju::beruju.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('beruju edit')) {
                    $edit = '<button class="btn btn-sm rounded-0" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('beruju delete')) {
                    $delete = '<button type="button" class="btn btn-sm rounded-0" wire:confirm="' . __('beruju::beruju.confirm_delete') . '" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('beruju edit')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-sub-category', subCategory: $id);
    }

    public function delete($id)
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $service = new SubCategoryAdminService();
        $service->delete(SubCategory::findOrFail($id));
        $this->successFlash(__('beruju::beruju.sub_category_deleted'));
    }

    public function deleteSelected()
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $service = new SubCategoryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
        $this->successFlash(__('beruju::beruju.sub_category_deleted_selected'));
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        // TODO: Create SubCategoriesExport class
        // return Excel::download(new SubCategoriesExport($records), 'sub-categories.xlsx');
    }
}
