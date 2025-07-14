<?php

namespace Src\Customers\Livewire;

use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Customers\Models\Customer;

class CustomerTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = Customer::class;
    public array $bulkActions = [

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
            //            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        $query = Customer::query()
            ->select('id', 'avatar', 'gender', 'kyc_verified_at', 'name', 'email', 'mobile_no')
            ->with([
                'kyc.permanentProvince',
                'kyc.permanentDistrict',
                'kyc.permanentLocalBody'
            ])
            ->orderBy('tbl_customers.updated_at', 'desc');

            $user = auth()->user()->fresh();

            if (!$user->hasRole('super-admin')) {
                $query->where(function ($q) use ($user) {
                    $q->whereHas('kyc', function ($subQuery) {
                        $subQuery->where('permanent_ward', GlobalFacade::ward());
                    })->orWhere('created_by', $user->id);
                });
            }

        return $query;
    }


    public function filters(): array
    {
        return [
            SelectFilter::make(__('KYC Verified'))
                ->options([
                    '' => __('All'),
                    '1' => __('Yes'),
                    '0' => __('No'),
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->whereNotNull('kyc_verified_at');
                    } elseif ($value === '0') {
                        $builder->whereNull('kyc_verified_at');
                    }
                }),
        ];
    }

    public function columns(): array
    {
        $columns = [
            // ImageColumn::make("Photo", "avatar")
            // ->location(
            //     fn($row) => $row->avatar ? asset('storage/customer/avatar/' . $row->avatar) : \Avatar::create($row->name)->toBase64()
            // )
            // ->attributes(fn($row) => [
            //     'style' => 'width:100px;border-radius:50%;display:flex;align-items:center;justify-content:center',
            //     'alt' => $row->name,
            // ]),

            Column::make(__('Customer Detail'))
                ->label(function ($row) {
                    return view('livewire-tables.includes.columns.customer_details', [
                        'name' => $row->name,
                        'email' => $row->email,
                        'mobile_no' => $row->mobile_no,
                    ]);
                })
                ->html()
                ->sortable()
                ->collapseOnTablet()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('mobile_no', 'like', "%{$term}%");
                }),

            Column::make(__("Gender"), "gender")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Permanent Address"))
                ->label(function ($row) {
                    return view('livewire-tables.includes.columns.address', ['customer' => $row])->render(); // Render the view to a string
                })
                ->html()
                ->collapseOnTablet(),
            Column::make(__("Status"))
                ->label(function ($row) {
                    return view('livewire-tables.includes.columns.customer_kyc_status', ['customer' => $row])->render(); // Render the view to a string
                })
                ->html()
                ->collapseOnTablet(),
        ];
        if (can('customer_access')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('customer_access')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
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

    //    public function view($id)
//    {
//        if (!can('customer view')) {
//            self::WARNING_FLASH('You Cannot Perform this action');
//            return false;
//        }
//        dd($id);
//        return redirect()->route('admin.customer.edit', ['id' => $id]);
//    }

    public function view($id)
    {
        if (!can('customer_access')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.customer.detail', $id);
    }
}

