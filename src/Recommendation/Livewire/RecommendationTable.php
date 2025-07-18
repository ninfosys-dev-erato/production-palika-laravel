<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Services\RecommendationAdminService;

class RecommendationTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Recommendation::class;

    public function configure(): void
    {
        $this->setPrimaryKey('rec_recommendations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['rec_recommendations.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return Recommendation::query()
            ->with(['form', 'recommendationCategory'])
            ->orderBy('rec_recommendations.created_at', 'desc')
            ->whereNull('rec_recommendations.deleted_by')
            ->whereNull('rec_recommendations.deleted_at');
    }

    public function filters(): array
    {
        return [
            // SelectFilter::make(__('recommendation::recommendation.status'))
            //     ->options([
            //         '' => 'All',
            //         ...collect(RecommendationStatusEnum::cases())
            //             ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            //             ->toArray()
            //     ])
            //     ->filter(function (Builder $builder, string $value) {
            //         if ($value !== '') {
            //             $builder->where('status', $value);
            //         }
            //     }),

        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('recommendation::recommendation.title'), "title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('recommendation::recommendation.form'), "form.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('recommendation::recommendation.recommendation_category'), "recommendationCategory.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];


        if (can('recommendation_update') || can('recommendation_delete')) {
            $columns[] = Column::make(__('recommendation::recommendation.actions'))
                ->label(function ($row) {
                    $buttons = '';


                    if (can('recommendation_update')) {
                        $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                        $buttons .= $edit;
                    }


                    if (can('recommendation_delete')) {
                        $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $delete;
                    }

                    if (can('recommendation_access')) {
                        $manage = '&nbsp;<button type="button" class="btn btn-success btn-sm ml-2" wire:click="manage(' . $row->id . ')"><i class="bx bx-cog"></i></button>';
                        $buttons .= $manage;
                    }

                    return $buttons;
                })
                ->html();
        }

        return $columns;
    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('recommendation_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.recommendations.recommendation.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('recommendation_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $service = new RecommendationAdminService();
        $service->delete(Recommendation::findOrFail($id));
        $this->successFlash(__('recommendation::recommendation.recommendation_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('recommendation_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $service = new RecommendationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function manage(int $recommendationId)
    {
        return redirect()->route('admin.recommendations.recommendation.manage', ['id' => $recommendationId]);
    }

}
