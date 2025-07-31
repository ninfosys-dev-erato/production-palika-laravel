<?php

namespace Src\Grievance\Livewire;

use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceDetailTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = GrievanceDetail::class;
    public array $bulkActions = [];


    public function configure(): void
    {
        $this->setPrimaryKey('gri_grievance_details.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['gri_grievance_details.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        $query = GrievanceDetail::query()
            ->with(['roles', 'grievanceType.branches'])
            ->whereNull(['grievance_detail_id', 'gri_grievance_details.deleted_at']);


        $user = Auth::user('web');

        if ($user->hasRole('super-admin')) {
            return $query->orderBy('gri_grievance_details.created_at', 'desc');
        }

        $userDepartmentIds = $user->departments?->pluck('id')->toArray();
        $userWardIds = GlobalFacade::ward();
        $userWardIds = $user->userWards()->pluck('ward')->toArray();
        $userRoleIds = $user->roles()->pluck('id')->toArray();

        $userWardIds = is_array($userWardIds) ? $userWardIds : [$userWardIds];

        $query->where(function ($subQuery) use ($userWardIds, $userDepartmentIds, $userRoleIds) {

            // CASE 1: Ward-based Grievances (is_ward = true)
            $subQuery->where(function ($q) use ($userWardIds, $userDepartmentIds) {
                $q->where('gri_grievance_details.is_ward', true)
                    ->where(function ($innerQ) use ($userWardIds, $userDepartmentIds) {
                        // Show to users who match ANY of these conditions:
                        $innerQ
                            // Condition 1:Auth User's ward matches grievance detail ward_id
                            ->whereIn('gri_grievance_details.ward_id', $userWardIds)
                            // Condition 2:Auth User's department matches any department mapped to grievance type
                            ->orWhereHas('grievanceType.branches', function ($branchQ) use ($userDepartmentIds) {
                                $branchQ->whereIn('mst_branches.id', $userDepartmentIds);
                            })
                            // Condition 3:Auth User's department matches directly assigned department by customer
                            ->orWhereIn('gri_grievance_details.branch_id', $userDepartmentIds);
                    });
            })

                // CASE 2: Non-Ward-based Grievances (is_ward = false)
                ->orWhere(function ($q) use ($userDepartmentIds, $userRoleIds) {
                    $q->where('gri_grievance_details.is_ward', false)
                        ->where(function ($innerQ) use ($userDepartmentIds, $userRoleIds) {
                            // Show to users who match ANY of these conditions:
                            $innerQ
                                // Condition 1: User's department matches any department mapped to grievance type
                                ->whereHas('grievanceType.branches', function ($branchQ) use ($userDepartmentIds) {
                                    $branchQ->whereIn('mst_branches.id', $userDepartmentIds);
                                })
                                // Condition 2: User's department matches directly assigned department by customer
                                ->orWhereIn('gri_grievance_details.branch_id', $userDepartmentIds)
                                // Condition 3: User has any role mapped to this grievance type
                                // (through gri_grievance_types -> tbl_grievance_types_roles -> roles)
                                ->orWhereHas('roles', function ($roleQ) use ($userRoleIds) {
                                    $roleQ->whereIn('roles.id', $userRoleIds);
                                });
                        });
                });
        });

        return $query->orderBy('gri_grievance_details.created_at', 'desc');
    }



    public function filters(): array
    {
        return [
            SelectFilter::make(__('grievance::grievance.status'))
                ->options([
                    '' => 'All',
                    'unseen' => 'Unseen',
                    'investigating' => 'Investigating',
                    'replied' => 'Replied',
                    'closed' => 'Closed',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status', $value);
                    }
                }),
            SelectFilter::make(__('grievance::grievance.priority'))
                ->options([
                    '' => 'All',
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('priority', $value);
                    }
                }),
            DateRangeFilter::make(__('grievance::grievance.date_range'))
                ->config([
                    'allowInput' => true,
                    'altFormat' => 'F j, Y',
                    'ariaDateFormat' => 'F j, Y',
                    'dateFormat' => 'Y-m-d',
                    'earliestDate' => '2020-01-01',
                    'latestDate' => now()->toDateString(),
                    'placeholder' => __('grievance::grievance.select_date_range'),
                ])
                ->filter(function ($query, array $dateRange) {
                    $query->whereDate('gri_grievance_details.created_at', '>=', $dateRange['minDate'])
                        ->whereDate('gri_grievance_details.created_at', '<=', $dateRange['maxDate']);
                })
                ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate']),
        ];
    }


    public function columns(): array
    {
        $columns = [
            Column::make(__('grievance::grievance.token_no'), "token")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.customer_name'), "customer.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.grievance_type'), "grievanceType.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.subject'), "subject")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.status'), 'status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->status->value
                    ]);
                })
                ->collapseOnTablet(),
            Column::make(__('grievance::grievance.priority'), 'priority')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->priority->value
                    ]);
                })
                ->collapseOnTablet(),

        ];
        if (can('grievance_detail_access')) {
            $actionsColumn = Column::make(__('grievance::grievance.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('grievance_detail_access')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }


                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}
    public function exportSelected() {}


    public function view($id)
    {
        if (!can('grievance_detail_access')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        return redirect()->route('admin.grievance.grievanceDetail.show', $id);
    }
}
