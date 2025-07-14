<?php

namespace Src\Recommendation\Livewire;

use Livewire\Component;
use Src\Meetings\Models\Meeting;
use Src\Recommendation\Models\Recommendation;

class RecommendationDetail extends Component
{
    public ?Recommendation $recommendation;
    public function mount(Recommendation $recommendation)
    {
       $this->recommendation = $recommendation;
    }

    public function render()
    {
        return view('Recommendation::livewire.recommendation.detail');
    }
}