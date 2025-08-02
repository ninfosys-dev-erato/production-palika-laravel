<?php

namespace Src\Wards\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Users\Exports\UsersExport;
use App\Models\User;
use Src\Users\Service\UserAdminService;

class UserTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = User::class;
    public $id;
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover text-center",
            ])
            ->setAdditionalSelects(['id', 'active'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }
    public function builder(): Builder
    {
        $wardId = $this->id;
        return User::with(['userWards', 'roles'])
            ->whereHas('userWards', function ($query) use ($wardId) {
                $query->where('ward', $wardId);
            });
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make("Name", "name")
                ->searchable(),
            Column::make("Email", "email")
                ->searchable(),
            Column::make(__('wards::wards.change_status'), 'active')
                ->format(function ($value, $row) {
                    $isActive = $row->active == 1;
                    return view('livewire-tables.includes.columns.status_switch', [
                        'rowId' => $row->id,
                        'isActive' => $isActive
                    ]);
                })
                ->html(),
            Column::make("Assigned Roles")->label(
                fn($row, Column $column) => view('Users::livewire.user-table.col-assignedTo')->with([
                    'roles' => $row->roles,
                ])
            )->html()
                ->searchable(),
        ];

        if (can('users edit') || can('users delete') || can('users manage')) {
            $actionsColumn = Column::make(__('wards::wards.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('users edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('users delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('users manage')) {
                    $manage = '&nbsp;<button type="button" class="btn btn-success btn-sm ml-2" wire:click="manage(' . $row->id . ')"><i class="bx bx-cog"></i></button>';
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
        if (!can('users edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }

        return redirect()->route('admin.users.edit', ['id' => $id, 'selectedward' => $this->id]);
    }
    public function delete($id)
    {
        if (!can('users delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new UserAdminService();
        $service->delete(User::findOrFail($id));
        $this->successFlash("User Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('users delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new UserAdminService();
        foreach ($this->getSelected() as $itemId) {
            $service->delete(User::findOrFail($itemId));
        }
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new UsersExport($records), 'users.xlsx');
    }

    public function role($userId)
    {
        return redirect()->route('admin.users.role', ['id' => $userId]);
    }

    public function permission($userId)
    {
        return redirect()->route('admin.users.permission', ['id' => $userId]);
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        $service = new UserAdminService();
        $service->toggleUserStatus($user);
    }

    public function manage(int $userId)
    {
        return redirect()->route('admin.users.manage', ['id' => $userId]);
    }
}
