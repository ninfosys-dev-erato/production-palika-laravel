<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\LetterTypeAdminDto;
use Src\Yojana\Models\LetterType;
use Src\Yojana\Service\LetterTypeAdminService;
use Livewire\Attributes\On;

class LetterTypeForm extends Component
{
    use SessionFlash;

    public ?LetterType $letterType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'letterType.title' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'letterType.title.required' => __('yojana::yojana.title_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.letter-types.form");
    }

    public function mount(LetterType $letterType, Action $action): void
    {
        $this->letterType = $letterType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = LetterTypeAdminDto::fromLiveWireModel($this->letterType);
        $service = new LetterTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.letter_type_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.letter_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->letterType, $dto);
                $this->successFlash(__('yojana::yojana.letter_type_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.letter_types.index');
                break;
            default:
                return redirect()->route('admin.letter_types.index');
                break;
        }
    }
    #[On('edit-letterType')]
    public function editLetterType(LetterType $letterType)
    {
        $this->letterType = $letterType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['letterType', 'action']);
        $this->letterType = new LetterType();
    }
}
