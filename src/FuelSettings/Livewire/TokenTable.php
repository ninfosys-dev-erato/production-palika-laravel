<?php

namespace Src\FuelSettings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\FuelSettings\Models\Token;
use Src\FuelSettings\Service\TokenAdminService;
use Src\Tokens\Exports\TokensExport;


class TokenTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Token::class;
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
        return Token::query()
            // ->where('deleted_at', null)
            // ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make("Token No", "token_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Fiscal Year Id", "fiscal_year_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Tokenable Type", "tokenable_type")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Tokenable Id", "tokenable_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Organization Id", "organization_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Fuel Quantity", "fuel_quantity")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Fuel Type", "fuel_type")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Status", "status")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Accepted At", "accepted_at")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Accepted By", "accepted_by")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Reviewed At", "reviewed_at")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Reviewed By", "reviewed_by")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Expires At", "expires_at")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Redeemed At", "redeemed_at")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Redeemed By", "redeemed_by")->sortable()->searchable()->collapseOnTablet(),
            Column::make("Ward No", "ward_no")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('tokens edit') || can('tokens delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('tokens edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('tokens delete')) {
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
        if (!can('tokens edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.tokens.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('tokens delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenAdminService();
        $service->delete(Token::findOrFail($id));
        $this->successFlash("Token Deleted Successfully");
    }
    public function deleteSelected()
    {
        if (!can('tokens delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new TokenAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new TokensExport($records), 'tokens.xlsx');
    }
}
