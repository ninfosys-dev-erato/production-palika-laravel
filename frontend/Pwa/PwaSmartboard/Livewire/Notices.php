<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\Notice;
use Illuminate\Support\Collection;


class Notices extends Component
{
    public Collection $notices;
    public Notice $selectedNotice;
    public int $ward;
    public function mount($ward = 0)
    {
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();

        // Ensure $selectedNotice is properly initialized
        $this->selectedNotice = $this->notices->first() ?? new Notice();
    }

    public function showNoticeDetail($id)
    {
        $this->selectedNotice = Notice::find($id) ?? new Notice();
        if (!$this->selectedNotice->file) {
            $this->selectedNotice->file = null; // Ensure file is null if not set
        }
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
        return view("Pwa.PwaSmartboard::livewire.notice-details");
    }
}
