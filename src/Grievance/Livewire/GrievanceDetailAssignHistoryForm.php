<?php

namespace Src\Grievance\Livewire;

use Livewire\Component;
use Src\Grievance\Models\GrievanceAssignHistory;

class GrievanceDetailAssignHistoryForm extends Component
{
    public $grievanceDetail;

    public function mount($grievanceDetail)
    {
        $this->grievanceDetail = $grievanceDetail;
    }

    public function render()
    {
        $grievanceDetails = GrievanceAssignHistory::with(['fromUser', 'toUser', 'grievanceDetail.investigationTypes'])
            ->where('grievance_detail_id', $this->grievanceDetail->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
            $groupedLogs = $grievanceDetails->groupBy(function ($log) {
                return $log->created_at->format('Y-m-d');
            });

        return view("Grievance::livewire.grievanceDetail.assignHistory", [
            'groupedLogs' => $groupedLogs,
        ]);
    }
}