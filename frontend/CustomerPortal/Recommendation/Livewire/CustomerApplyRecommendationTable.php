<?php

namespace Frontend\CustomerPortal\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationService;

class CustomerApplyRecommendationTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = ApplyRecommendation::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('rec_apply_recommendations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['rec_apply_recommendations.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms(['delete']);
    }

    public function builder(): Builder
    {
        return ApplyRecommendation::query()
            ->select('status')
            ->orderBy('rec_apply_recommendations.created_at', 'desc')
            ->where('customer_id', Auth::guard('customer')->id())
            ->whereNull('rec_apply_recommendations.deleted_by')
            ->whereNull('rec_apply_recommendations.deleted_at');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
           
            Column::make(__("recommendation::recommendation.recommendation"), "recommendation.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__("recommendation::recommendation.status"), "status")
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->status->value
                    ]);
                })
                ->collapseOnTablet(),
        ];

            $columns[] = Column::make(__('recommendation::recommendation.actions'))
                ->label(function ($row) {
                    $buttons = '';

                        $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                        $buttons .= $view;

                        if ( $row->status !== RecommendationStatusEnum::ACCEPTED) {
                            $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                            $buttons .= $edit;
                        }

                        $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $delete;

                    return $buttons;
                })
                ->html();

        return $columns;
    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        return redirect()->route('customer.recommendations.apply-recommendation.edit', ['id' => $id]);
    }

    public function view($id)
    {
        return redirect()->route('customer.recommendations.apply-recommendation.show',  $id);
    }

    public function delete($id)
    {
        $service = new RecommendationService();
        $service->delete(ApplyRecommendation::findOrFail($id));
        $this->successFlash(__("recommendation::recommendation.recommendation_deleted_successfully"));
    }

    // public function deleteSelected()
    // {
    //     $service = new RecommendationService();
    //     $service->collectionDelete($this->getSelected());
    //     $this->clearSelected();
    // }
}