<?php

namespace Src\Employees\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Employees\Models\Employee;
use Src\Employees\Service\EmployeeAdminService;

class EmployeeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = Employee::class;
    public $branchname; //branchname sent from branchemployee page 
    public $wardId; //ward sent from ward page

    public array $bulkActions = [

        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['mst_employees.id', 'mst_employees.user_id', 'mst_employees.branch_id', 'mst_employees.designation_id'])
            ->setBulkActionsDisabled()
            ->setReorderMethod('changeOrder')
            ->setReorderEnabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setDefaultReorderSort('mst_employees.position');
    }

    public function builder(): Builder
    {
        $branchname = $this->branchname; //set branchname
        $wardId = $this->wardId;

        return Employee::query()
            ->select('photo', 'name', 'email', 'phone')
            ->with(['branch', 'designation', 'user'])
            ->when($branchname, function ($query) use ($branchname) {
                $query->whereHas('branch', function ($query) use ($branchname) {
                    $query->where('id', $branchname);
                });
            })
            ->orderBy('position');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('employees::employees.kyc_verified'))
                ->options([
                    '' => __('employees::employees.all'),
                    '1' => __('employees::employees.yes'),
                    '0' => __('employees::employees.no'),
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->whereNotNull('kyc_verified_at');
                    } elseif ($value === '0') {
                        $builder->whereNull('kyc_verified_at');
                    }
                }),
            SelectFilter::make(__('employees::employees.kyc_verified'))
                ->options([
                    '' => __('employees::employees.all'),
                    '1' => __('employees::employees.yes'),
                    '0' => __('employees::employees.no'),
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

            Column::make(__('employees::employees.name'))->label(
                fn($row, Column $column) => view('Employees::livewire.employee-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%");
                }),
            Column::make(__('employees::employees.contact'))
                ->label(
                    fn($row, Column $column) => view('Employees::livewire.employee-table.col-contact')->with([
                        'row' => $row
                    ])->render()
                )->html()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%");
                }),
            Column::make(__('employees::employees.branch'), "branch.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('employees::employees.designation'), "designation.title")->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('employee update') || can('employee delete')) {
            $actionsColumn = Column::make(__('employees::employees.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('employee update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('employee delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }


                if ($row->user && $row->user->id && can('users_manage')) {

                    $manage = '&nbsp;<button type="button" class="btn btn-success btn-sm ml-2" wire:click="manage(' . $row->user->id . ')"><i class="bx bx-cog"></i></button>';
                    $buttons .= $manage;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
        if (!can('employee update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.employee.employee.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('employee delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EmployeeAdminService();
        $service->delete(Employee::findOrFail($id));
        $this->successFlash(__('employees::employees.employee_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('employee delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EmployeeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function changeOrder($items): void
    {
        foreach ($items as $item) {
            Employee::find((int)$item['id'])->update(['position' => (int)$item['mst_employees.position']]);
        }
    }

    public function manage(int $userId)
    {
        return redirect()->route('admin.users.manage', ['id' => $userId]);
    }
}
