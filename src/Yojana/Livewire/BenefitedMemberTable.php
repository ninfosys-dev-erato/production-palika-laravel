<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\BenefitedMembersExport;
use Src\Yojana\Models\BenefitedMember;
use Src\Yojana\Service\BenefitedMemberAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class BenefitedMemberTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = BenefitedMember::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
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
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return BenefitedMember::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('yojana::yojana.is_population'), "is_population")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('benefited_members edit') || can('benefited_members delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('benefited_members edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('benefited_members delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('benefited_members edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-benefitedMember', benefitedMember: $id);
        // return redirect()->route('admin.benefited_members.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('benefited_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BenefitedMemberAdminService();
        $service->delete(BenefitedMember::findOrFail($id));
        $this->successFlash(__('yojana::yojana.benefited_member_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('benefited_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BenefitedMemberAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BenefitedMembersExport($records), 'benefited_members.xlsx');
    }
}
