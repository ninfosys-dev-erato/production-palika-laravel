<?php

namespace Src\Beruju\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Beruju\Models\BerujuEntry;
use App\Traits\HelperDate;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BerujuEntryTable extends DataTableComponent
{
    use SessionFlash, HelperDate;

    protected $model = BerujuEntry::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover text-center",
            ])
            ->setAdditionalSelects([
                'brj_beruju_entries.id',
                'brj_beruju_entries.currency_type',
            ])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return BerujuEntry::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->with(['latestResolutionCycle.actions'])
            ->orderBy('created_at', 'DESC');
    }

    public function columns(): array
    {
        return [
           

            Column::make(__('beruju::beruju.reference_number'), 'reference_number')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return replaceNumbersWithLocale($value, true) ?: __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.contract_number'), 'contract_number')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return replaceNumbersWithLocale($value, true) ?: __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.entry_date'), 'entry_date')
                ->sortable()
                ->format(function ($value) {
                    return $value ?: __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.audit_type'), 'audit_type')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    try {
                        // Check if value is already an enum instance
                        if ($value instanceof BerujuAduitTypeEnum) {
                            return $value->label();
                        }
                        // If it's a string/int, convert to enum
                        $auditType = BerujuAduitTypeEnum::from($value);
                        return $auditType->label();
                    } catch (\Exception $e) {
                        return $value;
                    }
                }),

            Column::make(__('beruju::beruju.beruju_category'), 'beruju_category')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    try {
                        // Check if value is already an enum instance
                        if ($value instanceof BerujuCategoryEnum) {
                            return $value->label();
                        }
                        // If it's a string/int, convert to enum
                        $category = BerujuCategoryEnum::from($value);
                        return $category->label();
                    } catch (\Exception $e) {
                        return $value;
                    }
                }),

            Column::make(__('beruju::beruju.amount'), 'amount')
                ->sortable()
                ->format(function ($value, $row) {
                    if (!$value) return __('beruju::beruju.not_available');
                    $symbol = $row->currency_type
                        ? \Src\Beruju\Enums\BerujuCurrencyTypeEnum::symbol($row->currency_type)
                        : __('beruju::beruju.npr_symbol');
                    return $symbol . ' ' . replaceNumbersWithLocale(number_format((float)$value, 2), true);
                }),

            Column::make(__('beruju::beruju.resolved_amount'), 'id')
                ->format(function ($value, $row) {
                    $resolvedAmount = $row->resolved_amount;
                    if ($resolvedAmount == 0) return __('beruju::beruju.not_available');
                    $symbol = $row->currency_type
                        ? \Src\Beruju\Enums\BerujuCurrencyTypeEnum::symbol($row->currency_type)
                        : __('beruju::beruju.npr_symbol');
                    return $symbol . ' ' . replaceNumbersWithLocale(number_format((float)$resolvedAmount, 2), true);
                }),

            Column::make(__('beruju::beruju.owner_name'), 'owner_name')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value ?: __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.dafa_number'), 'dafa_number')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return replaceNumbersWithLocale($value, true) ?: __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.status'), 'status')
                ->sortable()
                ->format(function ($value) {
                    if (!$value) return __('beruju::beruju.not_available');
                    try {
                        // Check if value is already an enum instance
                        if ($value instanceof BerujuStatusEnum) {
                            return '<div style="display: flex; align-items: center;">
                                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: ' . $value->color() . '; margin-right: 8px;"></span>
                                        <span>' . $value->label() . '</span>
                                    </div>';
                        }
                        // If it's a string/int, convert to enum
                        $status = BerujuStatusEnum::from($value);
                        return '<div style="display: flex; align-items: center;">
                                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: ' . $status->color() . '; margin-right: 8px;"></span>
                                    <span>' . $status->label() . '</span>
                                </div>';
                    } catch (\Exception $e) {
                        return $value;
                    }
                })
                ->html(),

      

            Column::make(__('beruju::beruju.created_at'), 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value ? replaceNumbersWithLocale($this->adToBs($value,'Y-m-d'),true) : __('beruju::beruju.not_available');
                }),

            Column::make(__('beruju::beruju.actions'), 'id')
                ->format(function ($value, $row) {
                    $actions = '<div class="btn-group">';

                    if (Auth::user()->can('beruju view')) {
                        $actions .= '<a href="' . route('admin.beruju.registration.show', $value) . '" class="btn btn-sm  me-1"><i class="bx bx-show"></i></a>';
                    }

                    if (Auth::user()->can('beruju edit')) {
                        $actions .= '<a href="' . route('admin.beruju.registration.edit', $value) . '" class="btn btn-sm me-1"><i class="bx bx-edit"></i></a>';
                    }

                    if (Auth::user()->can('beruju delete')) {
                        $actions .= '<button wire:click="delete(' . $value . ')" class="btn btn-sm btn"><i class="bx bx-trash"></i></button>';
                    }

                    return $actions;
                })
                ->html(),
        ];
    }

    public function delete($id)
    {
        try {
            $berujuEntry = BerujuEntry::findOrFail($id);
            $berujuEntry->delete();
            $this->successFlash(__('beruju::beruju.beruju_deleted_successfully'));
        } catch (\Exception $e) {
            $this->errorFlash(__('beruju::beruju.something_went_wrong'));
        }
    }

    public function refresh() {}
}
