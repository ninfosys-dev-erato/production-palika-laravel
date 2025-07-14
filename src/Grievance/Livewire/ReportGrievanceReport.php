<?php

namespace Src\Grievance\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use App\Services\FilterQueryService;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Grievance\Models\GrievanceDetail;
class ReportGrievanceReport extends DataTableComponent
{

    use SessionFlash, IsSearchable;

    protected $model = GrievanceDetail::class;
    public array $bulkActions = [];


    public function configure(): void
    {
        $this->setPrimaryKey('gri_grievance_details.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects([
                'gri_grievance_details.id',
                'token',
                'grievance_detail_id',
                'grievance_type_id',
                'assigned_user_id',
                'customer_id',
                'branch_id',
                'subject',
                'description',
                'status',
                'approved_at',
                'is_public',
                'grievance_medium',
                'is_anonymous',
                'priority',
                'investigation_type',
                'documents',
                'escalation_date',
                'is_visible_to_public',
                'local_body_id',
                'ward_id',
                'gri_grievance_details.is_ward',
                'gri_grievance_details.created_at'
            ])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        $query = GrievanceDetail::query()
            ->with([
                'roles',
                'customer',
                'histories'
            ])
            ->whereNull(['grievance_detail_id', 'gri_grievance_details.deleted_at'])
            ->orderBy('gri_grievance_details.created_at', 'desc');
        $user = Auth::user('web');
        if ($user->hasRole('super-admin')) {
            return $query;
        }
        $userWardIds = $user->userWards()->pluck('ward')->toArray();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        $service = new FilterQueryService();
        $query = $service->filterByWard($query, $userWardIds);
        $query = $service->filterByRole($query, 'roles', $userRoleIds);
        return $query;
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
            Column::make(__('grievance::grievance.customer'))
            ->label(
                fn($row, Column $column) => view('Grievance::livewire.table.common-customer', [
                    'row' => $row->customer
                ])
            )
            ->html()
            ->searchable(function (Builder $query, $searchTerm) {
                $query->orWhereHas('customer', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('mobile_no', 'LIKE', "%{$searchTerm}%");
                });
            }),
            Column::make(__('grievance::grievance.grievance_against'), "grievanceType.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.subject'), "subject")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.assigned_users'))
            ->label(
                fn($row, Column $column) => view('Grievance::livewire.table.col-assign-history', [
                    'row' => $row->histories->load('fromUser', 'toUser')
                ])
            )->html(),
            Column::make(__('grievance::grievance.suggestions'), "suggestions")->sortable()->searchable()->collapseOnTablet(),
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