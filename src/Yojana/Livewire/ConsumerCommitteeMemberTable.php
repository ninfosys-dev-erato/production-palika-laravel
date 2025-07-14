<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Yojana\Exports\ConsumerCommitteeMembersExport;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\ConsumerCommitteeMember;
use Src\Yojana\Service\ConsumerCommitteeMemberAdminService;

class ConsumerCommitteeMemberTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = ConsumerCommitteeMember::class;
    public $consumerCommittee;
    public $isCommitteeSpecific = false;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function mount( $consumerCommittee = null)
    {
        $this->consumerCommittee = $consumerCommittee;
            if (isset($consumerCommittee) && $consumerCommittee instanceof ConsumerCommittee) {
            $this->isCommitteeSpecific = true;
        }
        session()->put('redirect_url', url()->current());

    }
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
        $query =  ConsumerCommitteeMember::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things

        if ($this->isCommitteeSpecific && $this->consumerCommittee instanceof ConsumerCommittee) {
            $query->where('consumer_committee_id', $this->consumerCommittee->id);
        }

        return $query;
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.citizenship_number'), "citizenship_number")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value ?: '-'),

            Column::make(__('yojana::yojana.name'), "name")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value ?: '-'),

            Column::make(__('yojana::yojana.address'), "address")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value ?: '-'),

            Column::make(__('yojana::yojana.gender'), "gender")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => __($value) ?: '-'),

            Column::make(__('yojana::yojana.father_name'), "father_name")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value ?: '-'),

            Column::make(__('yojana::yojana.grandfather_name'), "grandfather_name")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value ?: '-'),

            BooleanColumn::make(__('yojana::yojana.is_monitoring_committee'), "is_monitoring_committee")
                ->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('yojana::yojana.designation'), "designation")->sortable()->searchable()->collapseOnTablet()
                ->format(fn($value) => $value->label() ?: '-'),

            BooleanColumn::make(__('yojana::yojana.is_account_holder'), "is_account_holder")
                ->sortable()->searchable()->collapseOnTablet(),

            BooleanColumn::make(__('yojana::yojana.citizenship_upload'), "citizenship_upload")
                ->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('consumer_committee_members edit') || can('consumer_committee_members delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('consumer_committee_members edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('consumer_committee_members delete')) {
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
        if (!can('consumer_committee_members edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.consumer_committee_members.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('consumer_committee_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ConsumerCommitteeMemberAdminService();
        $service->delete(ConsumerCommitteeMember::findOrFail($id));
        $this->successFlash(__('yojana::yojana.consumer_committee_member_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('consumer_committee_members delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ConsumerCommitteeMemberAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ConsumerCommitteeMembersExport($records), 'consumer_committee_members.xlsx');
    }
}
