<?php

namespace Frontend\TokenPortal\TokenTv\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\TokenTracking\Models\RegisterToken;

class TokenTable extends DataTableComponent
{
    use SessionFlash;
   
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
   
        return RegisterToken::query()
            ->with(['branches', 'currentBranch'])
            
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Token"),
                'token'),
           
        ];
        return $columns;
    }
   
}
