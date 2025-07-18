<?php

namespace Src\BusinessRegistration\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Recommendation\Services\RecommendationService;

class BusinessDeRegistrationPreview extends Component
{
    use SessionFlash, BusinessRegistrationTemplate;
    public ?BusinessDeRegistration $businessDeRegistration;

    public $letter;
    public $template;
    public $style;

    public function mount(BusinessDeRegistration $businessDeRegistration)
    {
        $this->businessDeRegistration = $businessDeRegistration;

        $this->style = $this->businessDeRegistration->registrationType->form?->styles ?? "";

        $this->template = $this->resolveTemplate($this->businessDeRegistration);
    }

    public function render()
    {
        return view('BusinessRegistration::livewire.business-deregistration.preview');
    }

    // #[On('print-preview-business')]
    public function print()
    {
        $service = new BusinessRegistrationAdminService();
        return $service->getLetter($this->businessRegistration, 'web');
    }
}
