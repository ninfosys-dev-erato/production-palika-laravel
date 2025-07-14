<?php

namespace Src\Yojana\Livewire;

use Livewire\Component;

class ModalForm extends Component
{
    public $component;
    public $action;

    public function render()
    {
        return view("Yojana::livewire.modal.form");
    }

    public function mount($component, $action)
    {
        $this->component = $component;
        $this->action = $action;
    }
}
