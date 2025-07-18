<?php

namespace Src\Recommendation\Livewire;

use Livewire\Component;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\RecommendationLog;

class ApplyRecommendationAssign extends Component
{
    public $applyRecommendation = null;


    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation;
    }

    public function render()
    {
        $applyRecommendations = RecommendationLog::where('apply_recommendation_id', $this->applyRecommendation->id)
            ->orderBy('created_at','desc')
            ->get();
    
        $groupedLogs = $applyRecommendations->groupBy(function ($log) {
            return $log->created_at->format('Y-m-d');
        });
    
        return view("Recommendation::livewire.apply-recommendation.assign", [
            'groupedLogs' => $groupedLogs,
        ]);
    }
    
}
