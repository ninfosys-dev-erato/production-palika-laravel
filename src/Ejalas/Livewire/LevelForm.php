<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\LevelAdminDto;
use Src\Ejalas\Models\Level;
use Src\Ejalas\Service\LevelAdminService;
use Livewire\Attributes\On;

class LevelForm extends Component
{
    use SessionFlash;

    public ?Level $level;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'level.title' => ['required'],
            'level.title_en' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.level.form");
    }

    public function mount(Level $level, Action $action)
    {
        $this->level = $level;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = LevelAdminDto::fromLiveWireModel($this->level);
            $service = new LevelAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.level_created_successfully'));

                    // return redirect()->route('admin.ejalas.levels.index');

                    $this->dispatch('close-modal');
                    $this->resetForm();

                    break;
                case Action::UPDATE:
                    $service->update($this->level, $dto);
                    $this->successFlash(__('ejalas::ejalas.level_updated_successfully'));

                    // return redirect()->route('admin.ejalas.levels.index');

                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.levels.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-level')]
    public function editLevel(Level $level)
    {
        $this->level = $level;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['level', 'action']);
        $this->level = new Level();
    }
    #[On('reset-form')]
    public function resetLevel()
    {
        $this->resetForm();
    }
}
