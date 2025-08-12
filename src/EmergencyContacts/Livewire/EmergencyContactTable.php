<?php

namespace Src\EmergencyContacts\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Maatwebsite\Excel\Facades\Excel;
use Src\EmergencyContacts\Exports\EmergencyContactsExport;
use Src\EmergencyContacts\Models\EmergencyContact;
use Src\EmergencyContacts\Service\EmergencyContactAdminService;

class EmergencyContactTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = EmergencyContact::class;
    public array $bulkActions = [

        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100,500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return EmergencyContact::query()
            ->select('id', 'icon', 'service_name', 'contact_person', 'contact_numbers', 'address', 'site_map')
            ->where('deleted_at',null)
            ->where('deleted_by',null)
           ->orderBy('created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
        ImageColumn::make(__('emergencycontacts::emergencycontacts.icon'), "icon")->location(
            fn($row) => customFileAsset(config('src.EmergencyContacts.emergencyContact.icon_path'), $row->icon, 'local', 'tempUrl')
        )
            ->attributes(fn($row) => [
                'style' => 'width:100px;border-radius:50%',
                'alt' => $row->service_name ?? 'Emergency Contact Icon',
            ]),

            Column::make(__('emergencycontacts::emergencycontacts.service_name'), "service_name") ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('emergencycontacts::emergencycontacts.contact'))
                ->label(function ($row) {
                    return view('livewire-tables.includes.columns.emergency_contact', [
                        'contact_person' => $row->contact_person,
                        'address' => $row->address,
                        'contact_numbers' => $row->contact_numbers,
                    ]);
                })
                ->html()
                ->sortable()
                ->collapseOnTablet()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('contact_person', 'like', "%{$term}%")
                            ->orWhere('address', 'like', "%{$term}%")
                            ->orWhere('contact_numbers', 'like', "%{$term}%");
                }),
            Column::make(__('emergencycontacts::emergencycontacts.site_map'), "site_map")
                ->label(function ($row) {
                    $googleMapLink = $row->site_map;
                    return '<a href="' . $googleMapLink . '" target="_blank" class="btn btn-sm btn-info">' . __('emergencycontacts::emergencycontacts.view_on_google_maps') . '</a>';
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            ];
        if (can('emergency_contact_update') || can('emergency_contact_delete')) {
            $actionsColumn = Column::make(__('emergencycontacts::emergencycontacts.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('emergency_contact_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('emergency_contact_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('emergency_contact_update')){
               SessionFlash::WARNING_FLASH(__('emergencycontacts::emergencycontacts.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.emergency-contacts.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('emergency_contact_delete')){
                SessionFlash::WARNING_FLASH('you_cannot_perform_this_action');
                return false;
        }
        $service = new EmergencyContactAdminService();
        $service->delete(EmergencyContact::findOrFail($id));
        $this->successFlash(__('emergencycontacts::emergencycontacts.emergency_contact_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('emergency_contact_delete')){
            SessionFlash::WARNING_FLASH('you_cannot_perform_this_action');
            return false;
        }
        $service = new EmergencyContactAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new EmergencyContactsExport($records), 'emergency_contacts.xlsx');
    }
}
