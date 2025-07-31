<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\PartiesExport;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\PartyAdminService;
// use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class PartyTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Party::class;

    public $complainer_reg_no = null;
    public $type;
    public array $selectedParties = [];
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    protected $listeners = ['newPartyAdded' => 'fetchNewParty'];

    public function fetchNewParty($partyId)
    {
        $this->selectedParties = $partyId;
        $this->builder();
    }
    public function mount($complainer_reg_no = null, $type = null)
    {
        $this->complainer_reg_no = $complainer_reg_no;
        $this->type = $type;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('jms_parties.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_parties.id'])
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
        return Party::query()
            ->select(
                '*'
            )
            ->with([
                'permanentProvince',
                'temporaryProvince',
                'permanentDistrict',
                'temporaryDistrict',
                'permanentLocalBody',
                'temporaryLocalBody'
            ])

            ->whereNull('jms_parties.deleted_at')
            ->whereNull('jms_parties.deleted_by')
            ->when($this->type, function ($query) {

                $filteredIds = collect($this->selectedParties)
                    ->filter(fn($item) => $item['type'] === $this->type)
                    ->pluck('id')
                    ->toArray();
                Log::info($filteredIds);
                return $query->whereIn('id', $filteredIds);
            })

            ->orderBy('jms_parties.created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.personal_details'))
                ->label(function ($row) {
                    return (string) view('Ejalas::livewire.table.party.party-detail', [
                        'name' => $row->name ?? 'N/A',
                        'age' => $row->age ?? 'N/A',
                        'phoneNo' => $row->phone_no ?? 'N/A',
                        'citizenshipNo' => $row->citizenship_no ?? 'N/A',
                        'gender' => $row->gender ?? 'N/A',
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('age', 'like', "%{$term}%")
                        ->orWhere('phone_no', 'like', "%{$term}%")
                        ->orWhere('citizenship_no', 'like', "%{$term}%")
                        ->orWhere('gender', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),




            Column::make(__('ejalas::ejalas.family_details'))
                ->label(function ($row) {
                    $grandfather = $row->grandfather_name ? $row->grandfather_name : "N/A";
                    $father = $row->father_name ? $row->father_name : "N/A";
                    $spouse = $row->spouse_name ? $row->spouse_name : "N/A";

                    return "<strong>" . (__('ejalas::ejalas.grandfather')) . ":" . "</strong> {$grandfather} <br>
                <strong>" . (__('ejalas::ejalas.father')) . ":" . "</strong> {$father} <br>
                <strong>" . (__('ejalas::ejalas.spouse')) . ":" . "</strong> {$spouse}";
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('grandfather_name', 'like', "%{$term}%")
                        ->orWhere('father_name', 'like', "%{$term}%")
                        ->orWhere('spouse_name', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),

            // Permanent Address
            Column::make(__('ejalas::ejalas.permanent_address'))
                ->label(function ($row) {
                    return "<strong>" . (__('ejalas::ejalas.province')) . ":" . "</strong> " . ($row->permanentProvince->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.district')) . ":" . "</strong> " . ($row->permanentDistrict->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.local_body')) . ":" . "</strong> " . ($row->permanentLocalBody->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.ward')) . ":" . "</strong> " . ($row->permanent_ward_id ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.tole')) . ":" . "</strong> " . ($row->permanent_tole ?? "N/A");
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('permanentProvince', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhereHas('permanentDistrict', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhereHas('permanentLocalBody', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhere('permanent_ward_id', 'like', "%{$term}%")
                        ->orWhere('permanent_tole', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),
            // Temporary Address
            Column::make(__('ejalas::ejalas.temporary_address'))
                ->label(function ($row) {
                    return "<strong>" . (__('ejalas::ejalas.province')) . ":" . "</strong> " . ($row->temporaryProvince->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.district')) . ":" . "</strong> " . ($row->temporaryDistrict->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.local_body')) . ":" . "</strong> " . ($row->temporaryLocalBody->title ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.ward')) . ":" . "</strong> " . ($row->temporary_ward_id ?? "N/A") . "<br>
            <strong>" . (__('ejalas::ejalas.tole')) . ":" . "</strong> " . ($row->temporary_tole ?? "N/A");
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('temporaryProvince', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhereHas('temporaryDistrict', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhereHas('temporaryLocalBody', fn($q) => $q->where('title', 'like', "%{$term}%"))
                        ->orWhere('temporary_ward_id', 'like', "%{$term}%")
                        ->orWhere('temporary_tole', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),

        ];
        if (can('parties edit') || can('parties delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('parties edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
                if ($this->type == null) {
                    if (can('parties delete')) {
                        $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $delete;
                    }
                }

                if ($this->type) {
                    if (can('parties delete')) {
                        $deleteEntry = '<button type="button" class="btn btn-warning btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="deleteEntry(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                        $buttons .= $deleteEntry;
                    }
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
    public function edit($id)
    {
        if (!can('parties edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        // return redirect()->route('admin.ejalas.parties.edit', ['id' => $id]);
        return $this->dispatch('edit-party', $id);
    }
    public function delete($id)
    {
        if (!can('parties delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PartyAdminService();
        $service->delete(Party::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.party_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('parties delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PartyAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PartiesExport($records), 'parties.xlsx');
    }
    public function deleteEntry($id)
    {
        $this->dispatch('deleteEntryFromTable', $id);
    }
}
