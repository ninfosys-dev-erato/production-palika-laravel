<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\Ebps\Models\MapPassGroupUser;
use Src\MapPassGroups\Controllers\MapPassGroupAdminController;
use Src\Ebps\DTO\MapPassGroupAdminDto;
use Src\Ebps\Models\MapPassGroup;
use Src\Ebps\Service\MapPassGroupAdminService;

class MapPassGroupForm extends Component
{
    use SessionFlash;

    public ?MapPassGroup $mapPassGroup;
    public ?Action $action;
    public $addUsers = false;
    public $users = [];
    public $wards = [];
    public array $initialMapPassGroup= [];
    public array $selectedWards = [];
    public $userSelects = [];

    public function rules(): array
    {
        return [
            'mapPassGroup.title' => ['required'],
        ];
    }

    public function render(){
        return view("Ebps::livewire.map-pass-group.map-pass-group-form");
    }

    public function mount(MapPassGroup $mapPassGroup, Action $action)
{
    $this->mapPassGroup = $mapPassGroup;
    $this->action = $action;
    $this->wards = getWardsArray();
    $this->userSelects = [];

    $this->users = User::whereNull('deleted_at')->get()->toArray();

    if ($mapPassGroup->exists()) {
        $usersWithWards = MapPassGroupUser::where('map_pass_group_id', $mapPassGroup->id)
            ->get()
            ->groupBy('user_id');

        foreach ($usersWithWards as $userId => $userRecords) {
            $this->userSelects[] = $userId;
            $this->selectedWards[] = $userRecords->pluck('ward_no')->toArray();
        }
    }
}

    public function addUser()
    {
        $this->userSelects[] = '';
        $index = array_key_last($this->userSelects);
        $this->dispatch('add-user', $index);
    }

    public function removeUser($index)
    {
        unset($this->userSelects[$index]);
        $this->userSelects = array_values($this->userSelects);
    }

    public function save()
    {
        $this->validate();
        $dto = MapPassGroupAdminDto::fromLiveWireModel($this->mapPassGroup);
        $service = new MapPassGroupAdminService();
        DB::beginTransaction();
        try{
            switch ($this->action){
                case Action::CREATE:
                    $mapPassGroup = $service->store($dto);
                    $this->assignUsersToMapPassGroup($mapPassGroup->id);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_pass_group_created_successfully'));
                    return redirect()->route('admin.ebps.map_pass_groups.index');
                    break;
                case Action::UPDATE:
                    $mapPassGroup= $service->update($this->mapPassGroup,$dto);
                    $this->assignUsersToMapPassGroup($mapPassGroup->id);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_pass_group_updated_successfully'));
                    return redirect()->route('admin.ebps.map_pass_groups.index');
                    break;
                default:
                    return redirect()->route('admin.ebps.map_pass_groups.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    private function assignUsersToMapPassGroup($mapPassGroupId)
    {
        MapPassGroupUser::where('map_pass_group_id', $mapPassGroupId)->delete();
        foreach ($this->userSelects as $index => $userId) {
            $wards = $this->selectedWards[$index] ?? [];
            if (!is_array($wards)) {
                $wards = [$wards];
            }

            foreach ($wards as $wardNo) {
                MapPassGroupUser::create([
                    'map_pass_group_id' => $mapPassGroupId,
                    'user_id'           => $userId,
                    'ward_no'           => $wardNo,
                ]);
            }
        }
    }
}
