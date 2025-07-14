<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Livewire\Component;
use Src\Employees\Models\Employee;
use Illuminate\Support\Collection;

class Representatives extends Component
{
    public Collection $representatives;
    public int $ward;
    public function mount(int $ward = 0)
    {

        $this->representatives = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();
    }


    public function goBack()
    {
        if ($this->ward > 0) {
            return redirect()->route('smartboard.index', ['ward' => $this->ward]);
        }
        return redirect()->route('smartboard.index');
    }


    public function render()
    {
        return view("Pwa.PwaSmartboard::livewire.representative-details");
    }
}
