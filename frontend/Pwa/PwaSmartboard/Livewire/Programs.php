<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\Program;
use Illuminate\Support\Collection;

class Programs extends Component
{
    public Collection $programs;

    public Program $selectedProgram;
    public int $ward;
    public function mount($ward = 0)
    {

        $this->programs = Program::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->get();

        // Ensure $selectedNotice is properly initialized
        $this->selectedProgram = $this->programs->first() ?? new Program();
    }

    public function showProgramDetail($id)
    {
        $this->selectedProgram = Program::find($id) ?? new Program();
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
        return view("Pwa.PwaSmartboard::livewire.program-details");
    }
}
