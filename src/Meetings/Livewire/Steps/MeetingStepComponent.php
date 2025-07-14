<?php

namespace Src\Meetings\Livewire\Steps;

use Spatie\LivewireWizard\Components\StepComponent;

class MeetingStepComponent extends StepComponent
{
    public function render()
    {
        return view("Meetings::livewire.steps.meeting_step");
    }
}
