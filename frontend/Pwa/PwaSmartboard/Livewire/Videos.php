<?php

namespace Frontend\Pwa\PwaSmartboard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\Video;
use Illuminate\Support\Collection;

class Videos extends Component
{
    public Collection $videos;

    public Video $selectedVideo;
    public int $ward;
    public function mount($ward = 0)
    {
        $this->videos = Video::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->get();

        // Ensure $selectedVideo is properly initialized
        $this->selectedVideo = $this->videos->first() ?? new Video();
    }

    public function showVideoDetail($id)
    {
        $this->selectedVideo = Video::find($id) ?? new Video();
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
        return view("Pwa.PwaSmartboard::livewire.video-details");
    }
}
