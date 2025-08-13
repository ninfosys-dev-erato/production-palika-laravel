<?php

namespace Src\Beruju\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuPriorityEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BerujuEntryTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = BerujuEntry::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover text-center",
            ])
            ->setAdditionalSelects(['id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return BerujuEntry::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }



    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Title', 'title')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return '<strong>' . $value . '</strong>';
                })
                ->html(),

            Column::make('Reference Number', 'reference_number')
                ->sortable()
                ->searchable(),

            Column::make('Entry Date', 'entry_date')
                ->sortable()
                ->format(function ($value) {
                    return $value ? $value->format('Y-m-d') : 'N/A';
                }),

            Column::make('Amount', 'amount')
                ->sortable()
                ->format(function ($value, $row) {
                    return $value ? $row->currency_type . ' ' . number_format($value, 2) : 'N/A';
                }),

            Column::make('Status', 'status')
                ->sortable()
                ->format(function ($value) {
                    $status = BerujuStatusEnum::from($value);
                    return '<span class="badge bg-' . $status->color() . '">' . $status->label() . '</span>';
                })
                ->html(),

            Column::make('Priority', 'priority')
                ->sortable()
                ->format(function ($value) {
                    $priority = BerujuPriorityEnum::from($value);
                    return '<span class="badge bg-' . $priority->color() . '">' . $priority->label() . '</span>';
                })
                ->html(),

            Column::make('Assigned To', 'assigned_to')
                ->format(function ($value, $row) {
                    return $row->assignedTo ? $row->assignedTo->name : 'Not Assigned';
                }),

            Column::make('Submitted By', 'submitted_by')
                ->format(function ($value, $row) {
                    return $row->submittedBy ? $row->submittedBy->name : 'N/A';
                }),

            Column::make('Submitted At', 'submitted_at')
                ->sortable()
                ->format(function ($value) {
                    return $value ? $value->format('Y-m-d H:i') : 'N/A';
                }),

            Column::make('Actions', 'id')
                ->format(function ($value, $row) {
                    $actions = '';

                    if (Auth::user()->can('beruju view')) {
                        $actions .= '<a href="' . route('admin.beruju.show', $value) . '" class="btn btn-sm btn-info me-1"><i class="bx bx-show"></i></a>';
                    }

                    if (Auth::user()->can('beruju edit')) {
                        $actions .= '<a href="' . route('admin.beruju.edit', $value) . '" class="btn btn-sm btn-warning me-1"><i class="bx bx-edit"></i></a>';
                    }

                    if (Auth::user()->can('beruju delete')) {
                        $actions .= '<button wire:click="delete(' . $value . ')" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>';
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
