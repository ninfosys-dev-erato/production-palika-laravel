<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Employee;
use Src\Wards\Models\Ward;

class PwaTv extends Component
{
    public $employees;
    public $representatives;
    public Collection $programs;
    public int $ward;
    public function mount($ward = 0)
    {

        $this->employees = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();

        $this->representatives = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();


        // Fetch Programs
        $this->programs = Program::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->get();
    }


    public function render()
    {
        return view("Pwa.PwaSmartboard::livewire.digital-board");
    }
}
