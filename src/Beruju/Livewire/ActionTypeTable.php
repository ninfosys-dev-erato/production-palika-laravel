<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Beruju\Models\ActionType;
use Src\Beruju\Service\ActionTypeAdminService;
use Illuminate\Support\Str;

class ActionTypeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = ActionType::class;
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
        return ActionType::query()
            ->with(['subCategory', 'creator', 'updater'])
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
        return [
            Column::make(__('beruju::beruju.id'), 'id')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.name_eng'), 'name_eng')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.name_nep'), 'name_nep')
                ->sortable()
                ->searchable(),

            Column::make(__('beruju::beruju.sub_category'), 'sub_category_id')
                ->sortable()
                ->format(function ($value, $row) {
                    if (!$row->subCategory) return __('beruju::beruju.not_available');
                    $currentLocale = app()->getLocale();
                    return $currentLocale === 'ne' ? $row->subCategory->name_nep : $row->subCategory->name_eng;
                }),

            Column::make(__('beruju::beruju.remarks'), 'remarks')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    return Str::limit($value, 50);
                }),

            Column::make(__('beruju::beruju.form'), 'form_id')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    return $value;
                }),

            Column::make(__('beruju::beruju.created_by'), 'created_by')
                ->sortable()
                ->format(function ($value, $row) {
                    if (!$row->creator) return __('beruju::beruju.system');
                    return $row->creator->name;
                }),

            Column::make(__('beruju::beruju.created_at'), 'created_at')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    return $value->format('M d, Y H:i');
                }),

            Column::make(__('beruju::beruju.actions'), 'id')
                ->format(function ($value) {
                    $actions = '<div class="btn-group">';
                    
                    if (can('beruju edit')) {
                        $actions .= '<button class="btn btn-sm  me-1" onclick="editActionType(' . $value . ')">
                            <i class="bx bx-edit"></i>
                        </button>';
                    }
                    
                    if (can('beruju delete')) {
                        $actions .= '<button class="btn btn-sm " onclick="deleteActionType(' . $value . ')">
                            <i class="bx bx-trash"></i>
                        </button>';
                    }
                    
                    return $actions;
                })
                ->html(),
        ];
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('beruju edit')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-action-type', actionType: $id);
    }

    public function delete($id)
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $service = new ActionTypeAdminService();
        $service->delete(ActionType::findOrFail($id));
        $this->successFlash(__('beruju::beruju.action_type_deleted'));
    }

    public function deleteSelected()
    {
        if (!can('beruju delete')) {
            SessionFlash::WARNING_FLASH(__('beruju::beruju.you_cannot_perform_this_action'));
            return false;
        }
        $service = new ActionTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
        $this->successFlash(__('beruju::beruju.action_type_deleted_selected'));
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        // TODO: Create ActionTypesExport class
        // return Excel::download(new ActionTypesExport($records), 'action-types.xlsx');
    }
}
