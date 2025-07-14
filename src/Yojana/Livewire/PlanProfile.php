<?php

namespace Src\Yojana\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Src\Yojana\Models\Plan;

class PlanProfile extends Component
{
    public Plan $plan;
    public $color;
    public $icon;
    public $label;
    public $statusKey;

    protected $listeners = ['planStatusUpdate' => 'refreshPlan'];

    public function refreshPlan()
    {
        $this->plan->refresh();
        $currentStatus = $this->statusIcon();
        $this->color = $currentStatus['color'];
        $this->icon = $currentStatus['icon'];
    }

    public function mount(Plan $plan){
        $this->plan = $plan->load('implementationMethod','target');
    }

    public function render() : View
    {
        $currentStatus = $this->statusIcon();

        $this->color = $currentStatus['color'];
        $this->icon = $currentStatus['icon'];
        $this->label = $this->plan->status->label();

        return view('Yojana::livewire.plan-profile');
    }

    public function statusIcon()
    {
        $statusMap = [
            'plan_entry' => ['color' => '#6c757d', 'icon' => 'bx-pencil'],
            'project_incharge_appointed' => ['color' => '#0d6efd', 'icon' => 'bx-user'],
            'cost_estimation_entry' => ['color' => '#6610f2', 'icon' => 'bx-calculator'],
            'target_entry' => ['color' => '#20c997', 'icon' => 'bx-target-lock'],
            'cost_estimation_review' => ['color' => '#ffc107', 'icon' => 'bx-search-alt'],
            'cost_estimation_approved' => ['color' => '#198754', 'icon' => 'bx-check-circle'],
            'implementation_agency_appointed' => ['color' => '#0dcaf0', 'icon' => 'bx-building-house'],
            'agreement_completed' => ['color' => '#fd7e14', 'icon' => 'bx-file'],
            'advance_payment_completed' => ['color' => '#17a2b8', 'icon' => 'bx-credit-card'],
            'evaluation_completed' => ['color' => '#20c997', 'icon' => 'bx-task'],
            'completed' => ['color' => '#198754', 'icon' => 'bx-badge-check'],
        ];

        $statusKey = $this->plan->status?->value ?? 'plan_entry';
        $currentStatus = $statusMap[$statusKey] ?? ['color' => '#6c757d', 'icon' => 'bx-question-mark'];
        $this->statusKey = $statusKey;
        return $currentStatus;
    }

}
