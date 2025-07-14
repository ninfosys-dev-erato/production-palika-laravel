<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Address\Models\Province;
use Src\Ejalas\DTO\LocalLevelAdminDto;
use Src\Ejalas\Enum\LocalLevelType;
use Src\Ejalas\Models\LocalLevel;
use Src\Ejalas\Service\LocalLevelAdminService;
use Livewire\Attributes\On;

class LocalLevelForm extends Component
{
    use SessionFlash;

    public ?LocalLevel $localLevel;
    public ?Action $action;
    public $provinces;
    public $districts = [];
    public $localBodies = [];
    public $localLevelTypes;

    public function rules(): array
    {
        return [
            'localLevel.title' => ['required'],
            'localLevel.short_title' => ['required'],
            'localLevel.type' => ['required'],
            'localLevel.province_id' => ['required'],
            'localLevel.district_id' => ['required'],
            'localLevel.local_body_id' => ['required'],
            'localLevel.mobile_no' => ['nullable', 'max:10'],
            'localLevel.email' => ['nullable', 'email'],
            'localLevel.website' => ['nullable'],
            'localLevel.position' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.local-level.form");
    }

    public function mount(LocalLevel $localLevel, Action $action)
    {
        $this->localLevel = $localLevel;
        $this->action = $action;

        $this->provinces = Province::pluck('title', 'id');

        $this->localLevelTypes = LocalLevelType::cases();

        if ($this->localLevel) {
            $this->getDistrict();
            $this->getLocalBody();
        }
    }

    public function getDistrict()
    {
        $this->districts = getDistricts($this->localLevel['province_id'])->pluck('title', 'id');
    }
    public function getLocalBody()
    {
        $this->localBodies = getLocalBodies(district_ids: $this->localLevel['district_id'])->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = LocalLevelAdminDto::fromLiveWireModel($this->localLevel);
            $service = new LocalLevelAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.local_level_created_successfully'));
                    // return redirect()->route('admin.ejalas.local_levels.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->localLevel, $dto);
                    $this->successFlash(__('ejalas::ejalas.local_level_updated_successfully'));
                    // return redirect()->route('admin.ejalas.local_levels.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.local_levels.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-local-level')]
    public function editLocalLevel(LocalLevel $localLevel)
    {
        $this->localLevel = $localLevel;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['localLevel', 'action']);
        $this->localLevel = new LocalLevel();
    }
    #[On('reset-form')]
    public function resetLocalLevel()
    {
        $this->resetForm();
    }
}
