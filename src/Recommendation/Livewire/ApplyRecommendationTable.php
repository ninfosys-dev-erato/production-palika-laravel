<?php

namespace Src\Recommendation\Livewire;

use App\Facades\GlobalFacade;
use App\Services\FilterQueryService;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationService;

class ApplyRecommendationTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = ApplyRecommendation::class;


    public function configure(): void
    {
        $this->setPrimaryKey('rec_apply_recommendations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['rec_apply_recommendations.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        $query =  ApplyRecommendation::query()
            ->with(['customer', 'roles', 'recommendation.branches'])
            ->whereNull('rec_apply_recommendations.deleted_by')
            ->whereNull('rec_apply_recommendations.deleted_at')
            ->orderBy('rec_apply_recommendations.created_at', 'desc');

        $user = auth()->user()->fresh();

        if ($user->hasRole('super-admin')) {
            return $query;
        }

        $userDepartmentIds = $user->departments?->pluck('id')->toArray();
        $userWardIds = GlobalFacade::ward();
        $userRoleIds = $user->roles->pluck('id')->toArray();

        $userWardIds = is_array($userWardIds) ? $userWardIds : [$userWardIds];

        // if (empty(array_filter($userWardIds))) {
        //     $query->where('rec_apply_recommendations.created_by', $user->id);
        //     return $query;
        // }

        $query->where(function ($subQuery) use ($userDepartmentIds, $userWardIds, $userRoleIds) {
            $subQuery->where(function ($q) use ($userWardIds, $userDepartmentIds) {
                $q->where('rec_apply_recommendations.is_ward', true)
                    ->where(function ($innerQuery) use ($userWardIds, $userDepartmentIds) {
                        $innerQuery->whereIn('rec_apply_recommendations.ward_id', $userWardIds)
                            ->orWhereHas('recommendation.branches', function ($branchQ) use ($userDepartmentIds) {
                                $branchQ->whereIn('mst_branches.id', $userDepartmentIds);
                            });
                    });
            });
        })
            ->orWhere(function ($q) use ($userDepartmentIds, $userRoleIds) {
                $q->where('rec_apply_recommendations.is_ward', false)
                    ->where(function ($innerQuery) use ($userRoleIds, $userDepartmentIds) {
                        $innerQuery->whereHas('recommendation.branches', function ($branchQ) use ($userDepartmentIds, $userRoleIds) {
                            $branchQ->whereIn('mst_branches.id', $userDepartmentIds)
                                ->orWhereHas('users', function ($userQuery) use ($userRoleIds) {
                                    $userQuery->whereHas('roles', function ($roleQuery) use ($userRoleIds) {
                                        $roleQuery->whereIn('roles.id', $userRoleIds);
                                    });
                                });
                        });
                    });
            });

        return $query;
    }

    public function filters(): array
    {
        return [
              SelectFilter::make(__('recommendation::recommendation.status'))
                ->options([
                    '' => 'All',
                    ...collect(RecommendationStatusEnum::cases())
                        ->mapWithKeys(fn($status) => [$status->value => $status->label()])
                        ->toArray()
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status', $value);
                    }
                }),
        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('recommendation::recommendation.customer'), "customer.name")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('recommendation::recommendation.recommendation'), "recommendation.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('recommendation::recommendation.status'), 'status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->status->value
                    ]);
                })
                ->collapseOnTablet(),
        ];


        if (can('recommendation_apply update') || can('recommendation_apply delete')) {
            $columns[] = Column::make(__('recommendation::recommendation.actions'))
                ->label(function ($row) {
                    $buttons = '';

                    if (can('recommendation_apply access')) {
                        $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                        $buttons .= $view;
                    }

                    if (can('recommendation_apply update') && $row->status !== RecommendationStatusEnum::ACCEPTED) {
                        $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                        $buttons .= $edit;
                    }

                    if (can('recommendation_apply delete') && $row->status !== RecommendationStatusEnum::ACCEPTED) {
                        $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $delete;
                    }

                    if ($row->status === RecommendationStatusEnum::ACCEPTED) {
                        $preview = '<button type="button" class="btn btn-primary btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                        $buttons .= $preview;
                    }

                    return $buttons;
                })
                ->html();
        }

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('recommendation_apply update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.recommendations.apply-recommendation.edit', ['id' => $id]);
    }

    public function view($id)
    {
        if (!can('recommendation_apply access')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.recommendations.apply-recommendation.show',  $id);
    }

    public function delete($id)
    {
        if (!can('recommendation_apply delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $service = new RecommendationService();
        $service->delete(ApplyRecommendation::findOrFail($id));
        $this->successFlash(__('recommendation::recommendation.recommendation_settings deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('recommendation_apply delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        $service = new RecommendationService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function preview( $id)
    {
        return redirect()->route('admin.recommendations.preview', ['id' => $id]);
    }
}
