<?php

namespace Src\DigitalBoard\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\DigitalBoard\Exports\PopUpsExport;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Service\PopUpAdminService;

class PopUpTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = PopUp::class;
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
        return PopUp::query()
            ->with('wards')
            ->select('title', 'display_duration', 'iteration_duration')
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
            Column::make(__('digitalboard::digitalboard.photo'), "photo")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value, $row) {
                    if ($value) {
                        return "<img src='" . customAsset(config('src.DigitalBoard.popup.popup_path'), $value) . "'
                                alt='Popup Photo'
                                style='width: 250px; height: 150px; object-fit: cover; border-radius: 5px;'>";
                    }
                    return "No Image";
                })
                ->html(),
            Column::make(__('digitalboard::digitalboard.popup'))
                ->label(function ($row) {
                    return view('DigitalBoard::livewire.table-columns.popup-column')->with([
                        'title' => $row->title,
                        'iterationDuration' => $row->iteration_duration,
                        'displayDuration' => $row->display_duration,
                        'wards' => $row->wards->isEmpty() ? 'N/A' : $row->wards->pluck('ward')->implode(', ')
                    ])
                        ->render();
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('digitalboard::digitalboard.is_active'), "is_active")
                ->format(function ($value, $row) {
                    $isActive = $row->is_active == 1;
                    $toggleFunction = 'toggleActiveStatus';
                    return '
                            <div class="text-center">
                                <label class="switch">
                                    <input type="checkbox" wire:click="' . $toggleFunction . '(' . $row->id . ')" ' . ($isActive ? 'checked' : '') . '
                                    wire:confirm="Are you sure you want to change the active status?">
                                    <span class="slider">
                                        <span class="slider-before"></span>
                                    </span>
                                </label>
                            </div>';
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('digitalboard::digitalboard.can_show_on_palika'), 'can_show_on_admin')
                ->format(function ($value, $row) {
                    $canShowOnAdmin = $row->can_show_on_admin == 1;
                    return view('livewire-tables.includes.columns.status_switch', [
                        'rowId' => $row->id,
                        'isActive' => $canShowOnAdmin
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];
        if (can('digital_board edit') || can('digital_board delete')) {
            $actionsColumn = Column::make(__('digitalboard::digitalboard.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('digital_board edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('digital_board delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('digital_board edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.digital_board.pop_ups.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PopUpAdminService();
        $service->delete(PopUp::findOrFail($id));
        $this->successFlash(__("Pop Up Deleted Successfully"));
    }
    public function deleteSelected()
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PopUpAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PopUpsExport($records), 'pop_ups.xlsx');
    }
    public function toggleStatus($id)
    {
        $notice = PopUp::findOrFail($id);
        $service = new PopUpAdminService();
        $service->toggleCanShowOnAdmin($notice);
    }
    public function toggleActiveStatus($id)
    {
        $notice = PopUp::findOrFail($id);
        $service = new PopUpAdminService();
        $service->toggleIsActive($notice);
    }
}
