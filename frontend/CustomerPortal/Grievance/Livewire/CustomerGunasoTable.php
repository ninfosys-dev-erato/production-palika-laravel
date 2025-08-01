<?php

namespace Frontend\CustomerPortal\Grievance\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\Grievance\Models\GrievanceDetail;


class CustomerGunasoTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = GrievanceDetail::class;
    public array $bulkActions = [

    ];

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
        return GrievanceDetail::query()
            ->with(['files', 'grievanceType', 'customer'])
            ->where('is_anonymous', false)
            ->where('is_public', true)
            ->where('is_visible_to_public', true)
            ->orderBy('gri_grievance_details.created_at', 'desc');
    }

    public function filters(): array
{
    return [
        SelectFilter::make(__('View'))
            ->options([
                'all' => __('All Grievances'),
                'my' => __('My Grievances'),
            ])
            ->filter(function (Builder $builder, string $value) {
                if ($value === 'my') {
                    $builder->where('customer_id', Auth::guard('customer')->user()->id);
                }else{
                    $builder->where('is_public', true) ->where('is_anonymous', false)->where('is_visible_to_public', true);
                }

            }),
        SelectFilter::make(__('grievance::grievance.status'))
            ->options([
                '' => __('All'),
                'unseen' => __('Unseen'),
                'investigating' => __('Investigating'),
                'replied' => __('Replied'),
                'closed' => __('Closed'),
            ])
            ->filter(function (Builder $builder, string $value) {
                if ($value !== '') {
                    $builder->where('status', $value);
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
            Column::make(__("grievance::grievance.token_no"), "token")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("grievance::grievance.customer_name"), "customer.name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("grievance::grievance.grievance_type"), "grievanceType.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("grievance::grievance.subject"), "subject")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.status'), 'status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->status->value
                    ]);
                })
                ->collapseOnTablet(),
            // Column::make(__('Priority'), 'priority')
            //     ->format(function ($value, $row) {
            //         return view('livewire-tables.includes.columns.status_text', [
            //             'status' => $row->priority->value
            //         ]);
            //     })
            //     ->collapseOnTablet(),

        ];
        // if (can('grievance_detail_access')) {
            $actionsColumn = Column::make(__('grievance::grievance.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                // if (can('grievance_detail_access')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                // }


                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        // }

        return $columns;
    }

    public function refresh() {}


    public function view($id)
    {
        // if (!can('grievance_detail_access')) {
            // self::WARNING_FLASH('You Cannot Perform this action');
            // return false;
        // }

        return redirect()-> route('customer.grievance.show', $id);
    }
}
