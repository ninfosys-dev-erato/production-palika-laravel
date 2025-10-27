<?php

namespace Src\Ejalas\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\Models\ComplaintRegistration;

class ComplaintRegistrationForwardForm extends Component
{
    use SessionFlash;

    public ComplaintRegistration $complaintRegistration;
    public $complainer;
    public $defender;

    public function mount(ComplaintRegistration $complaintRegistration): void
    {
        $this->complaintRegistration = $complaintRegistration->load([
        'fiscalYear',
        'priority',
        'disputeMatter',
        'disputeMatter.disputeArea',
        'parties',
        'hearingSchedule',
        'courtNotice',
        'writtenResponseRegistration',
        'mediatorSelection',
        'witnessesRepresentative',
        'settlement',
        'caseRecord',
        'disputeDeadline',
        'disputeRegistrationCourt',
    ]);
    }

    public function render()
    {
        return view('Ejalas::livewire.complaint-registration.forward-form');
    }
}


