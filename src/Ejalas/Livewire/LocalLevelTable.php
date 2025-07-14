<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\LocalLevelsExport;
use Src\Ejalas\Models\LocalLevel;
use Src\Ejalas\Service\LocalLevelAdminService;

class LocalLevelTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = LocalLevel::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_local_levels.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_local_levels.id'])
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
        return LocalLevel::query()
            ->select(
                'title',
                'short_title',
                'type',
                'province_id',
                'district_id',
                'local_body_id',
                'mobile_no',
                'email',
                'website',
                'position',
            )
            ->with(['province', 'district', 'localBody'])
            ->where('jms_local_levels.deleted_at', null)
            ->where('jms_local_levels.deleted_by', null)
            ->orderBy('jms_local_levels.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.ejalashlocallevellisttitle'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ejalashlocallevellistsurname'), "short_title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ejalashlocallevellisttype'), "type")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.location'))
                ->label(function ($row) {
                    return "<strong>" . (__('ejalas::ejalas.province')) . ":" . "</strong> " . ($row->province->title ?? "N/A") . "<br>
                            <strong>" . (__('ejalas::ejalas.district')) . ":" . "</strong> " . ($row->district->title ?? "N/A") . "<br>
                            <strong>" . (__('ejalas::ejalas.local_body')) . ":" . "</strong> " . ($row->localBody->title ?? "N/A");
                })
                ->html()
                ->sortable(),

            Column::make(__('ejalas::ejalas.contact_details'))
                ->label(function ($row) {
                    return "<strong>" . (__('ejalas::ejalas.mobile_no')) . ":" . "</strong> " . ($row->mobile_no ?? "N/A") . "<br>
                            <strong>" . (__('ejalas::ejalas.email')) . ":" . "</strong> " . ($row->email ?? "N/A") . "<br>
                            <strong>" . (__('ejalas::ejalas.website')) . ":" . "</strong> " . ($row->website ?? "N/A");
                })
                ->html()
                ->sortable()
                ->searchable(),

            Column::make(__('ejalas::ejalas.position'), "position")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('local_levels edit') || can('local_levels delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('local_levels edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('local_levels delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('local_levels edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-local-level', $id);
        // return redirect()->route('admin.ejalas.local_levels.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('local_levels delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LocalLevelAdminService();
        $service->delete(LocalLevel::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.local_level_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('local_levels delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LocalLevelAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new LocalLevelsExport($records), 'local_levels.xlsx');
    }
}
