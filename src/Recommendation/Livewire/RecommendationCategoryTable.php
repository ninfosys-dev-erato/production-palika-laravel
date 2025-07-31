<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationCategoryAdminService;

class RecommendationCategoryTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = RecommendationCategory::class;
    public array $bulkActions = [

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
        return RecommendationCategory::query()
            ->whereNull('rec_recommendation_categories.deleted_by')
            ->whereNull('rec_recommendation_categories.deleted_at')
            ->orderBy('rec_recommendation_categories.created_at', 'desc');


    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('recommendation::recommendation.title'), "title")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('recommendation_category_update') || can('recommendation_category_delete')) {
            $actionsColumn = Column::make(__('recommendation::recommendation.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('recommendation_category_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('recommendation_category_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
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
        if (!can('recommendation_category_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.recommendations.recommendation-category.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('recommendation_category_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RecommendationCategoryAdminService();
        $service->delete(RecommendationCategory::findOrFail($id));
        $this->successFlash(__('recommendation::recommendation.recommendation_category_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('recommendation_category_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new RecommendationCategoryAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }


}
