<?php

namespace Frontend\Pwa\PwaTv\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Employee;
use Src\Wards\Models\Ward;

class PwaTv extends Component
{
    public $citizenharters;
    public $employees;
    public $representatives;
    public $programs;
    public $videos;
    public $notices;
    public int $ward;
    public function mount($ward = 0)
    {
        // Fetch Citizen Charters with conditional filtering
        $this->citizenharters = CitizenCharter::whereNull(['deleted_at', 'deleted_by'])
            ->when($ward === 0, function ($query) {
                return $query->where('can_show_on_admin', true);
            })
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Employees with ward filter
        $this->employees = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->when($ward == 0, function ($query) {
                return $query->where(function ($q2) {
                    $q2->whereNull('ward_no')
                        ->orWhere('ward_no', 0);
                }); // Or whatever your default filter should be
            })
            ->orderBy('position')
            ->get();

        // Fetch Representatives with ward filter
        $this->representatives = Employee::with('designation')
            ->whereNull(['deleted_at', 'deleted_by'])
            ->where('type', 'representative')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->when($ward == 0, function ($query) {
                return $query->where(function ($q2) {
                    $q2->whereNull('ward_no')
                        ->orWhere('ward_no', 0);
                }); // Or whatever your default filter should be
            })
            ->orderBy('position')
            ->get();


        // Fetch Programs
        $this->programs = Program::whereNull(['deleted_at', 'deleted_by'])
            ->when($ward === 0, function ($query) {
                return $query->where('can_show_on_admin', true);
            })
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Videos
        $this->videos = Video::whereNull(['deleted_at', 'deleted_by'])
            ->when($ward === 0, function ($query) {
                return $query->where('can_show_on_admin', true);
            })
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::whereNull(['deleted_at', 'deleted_by'])
            ->when($ward === 0, function ($query) {
                return $query->where('can_show_on_admin', true);
            })
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

    }


    public function render()
    {
        return view("Pwa.PwaTv::digital-board");
    }
}
