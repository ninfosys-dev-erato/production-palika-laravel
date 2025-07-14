<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Program;

class ProgramDetail extends Component
{
    public Program $selectedProgram;
    public $filterType = 'palika';
    public $latestPrograms = [];


    public function mount(Program $program)
    {
        $this->selectedProgram = $program; 
        $this->latestPrograms = Program::whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get(); 

        $this->filterType = 'palika';

    }

    public function showProgramDetail($id)
    {
       
        $this->selectedProgram = Program::find($id);
    }

    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.program.program-detail', [
            'selectedProgram' => $this->selectedProgram,
            'latestPrograms' => $this->latestPrograms,
            'filterType' => $this->filterType,
        ]);
    }
    
}
