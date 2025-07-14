<?php

namespace Frontend\Pwa\PwaKiosk\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Employee;

class PwaKiosk extends Component
{
    public $citizenharters;
    public $employees;
    public $representatives;
    public $programs;
    public $videos;
    public $notices;
    public int $ward;

   public function mount(int $ward=0)
  {

     $this->videos = Video::where('can_show_on_admin', true)->whereNull(['deleted_at', 'deleted_by'])->when($ward > 0, function ($query) use ($ward) {
         return $query->whereHas('wards', function ($q) use ($ward) {
             $q->where('ward', $ward);
         });
     })->get();

       $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
           ->whereNull(['deleted_at', 'deleted_by'])
           ->when($ward > 0, function ($query) use ($ward) {
               return $query->whereHas('wards', function ($q) use ($ward) {
                   $q->where('ward', $ward);
               });
           })
           ->get();

       // Fetch Employees with optional ward filter and ordered by position
       $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
           ->with('designation')
           ->when($ward > 0, function ($query) use ($ward) {
               return $query->where('ward_no', $ward);
           })
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

       // Fetch Notices (latest 4)
       $this->notices = Notice::where('can_show_on_admin', true)
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
        return view("Pwa.PwaKiosk::digital-board");
    }
}
